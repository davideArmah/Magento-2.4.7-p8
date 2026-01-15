<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model;

use Armah\CrossLinks\Api\LinkInterface;
use Armah\CrossLinks\Helper\Data;
use Armah\CrossLinks\Model\LinkUrl\CategoryProvider;
use Armah\CrossLinks\Model\LinkUrl\ProductProvider;
use Armah\CrossLinks\Model\ResourceModel\Link as LinkResource;
use Armah\CrossLinks\Model\Source\ReferenceType;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class Link extends AbstractModel implements LinkInterface
{
    public const DEFAULT_LINK_URL = '#';

    public const STATUS_INACTIVE = 0;

    public const STATUS_ACTIVE = 1;

    public function __construct(
        Context $context,
        Registry $registry,
        ?Data $helper, // @deprecated
        private readonly StoreManagerInterface $storeManager,
        ?ProductRepositoryInterface $productRepository = null,// @deprecated
        ?CategoryRepositoryInterface $categoryRepository = null,// @deprecated
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,
        array $data = [],
        private ?ProductProvider $productProvider = null, // TODO move to not optional
        private ?CategoryProvider $categoryProvider = null // TODO move to not optional
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        if ($this->productProvider === null) {
            // OM for backward compatibility
            $this->productProvider = ObjectManager::getInstance()
                ->get(ProductProvider::class);
        }
        if ($this->categoryProvider === null) {
            // OM for backward compatibility
            $this->categoryProvider = ObjectManager::getInstance()
                ->get(CategoryProvider::class);
        }
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(LinkResource::class);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->setData('title', $title);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return explode("\r\n", $this->getData('keywords'));
    }

    /**
     * @param string $innerText
     * @param string|null $linkUrl
     * @return string
     */
    public function getLinkHtml($innerText, ?string $linkUrl = null)
    {
        $link = $linkUrl ?? $this->getLinkUrl();

        return '<a href="' . $link . '" title="' . $this->getTitle() . '"'
            . ($this->getIsNofollow() ? ' rel="nofollow"' : '')
            . ' target="' . $this->getLinkTarget() . '"'
            . '>' . $innerText . '</a>';
    }

    /**
     * @return string
     */
    public function getLinkUrl()
    {
        switch ($this->getReferenceType()) {
            case ReferenceType::REFERENCE_TYPE_CUSTOM:
                $uri = $this->getCustomUrl();
                break;
            case ReferenceType::REFERENCE_TYPE_PRODUCT:
                $uri = $this->getProductUrl();
                break;
            case ReferenceType::REFERENCE_TYPE_CATEGORY:
                $uri = $this->getCategoryUrl();
                break;
            default:
                $uri = self::DEFAULT_LINK_URL;
        }

        return $uri;
    }

    /**
     * @return string
     */
    public function getCustomUrl(?string $referenceResource = null): string
    {
        $reference = $referenceResource ?? $this->getReferenceResource();

        return strpos($reference, 'http') === 0 ?
            $reference
            : $this->storeManager->getStore()->getBaseUrl() . trim($reference, '/');
    }

    /**
     * @param string|null $referenceResource
     * @return ProductInterface|null
     */
    public function getProduct(?string $referenceResource = null): ?ProductInterface
    {
        $id = $referenceResource ?? $this->getReferenceResource();

        return $this->productProvider->getProduct((int)$id);
    }

    /**
     * @param string|null $referenceResource
     * @return CategoryInterface|null
     */
    public function getCategory(?string $referenceResource = null): ?CategoryInterface
    {
        $id = $referenceResource ?? $this->getReferenceResource();

        return $this->categoryProvider->getCategory((int)$id);
    }

    public function getProductUrl(?string $referenceResource = null): string
    {
        $productUrl = self::DEFAULT_LINK_URL;
        if ($product = $this->getProduct($referenceResource)) {
            $productUrl = $product->getProductUrl();
        }

        return $productUrl;
    }

    public function getCategoryUrl(?string $referenceResource = null): string
    {
        $categoryUrl = self::DEFAULT_LINK_URL;
        if ($category = $this->getCategory($referenceResource)) {
            $categoryUrl = $category->getUrl();
        }

        return $categoryUrl;
    }
}
