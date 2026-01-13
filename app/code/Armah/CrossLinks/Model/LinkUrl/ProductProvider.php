<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkUrl;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ProductProvider
{
    /**
     * @var array
     */
    private array $storage = [];

    public function __construct(
        private readonly CollectionFactory $productCollectionFactory,
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Return product with minimal information, required for URL generation
     *
     * @param int $productId
     * @return Product|null
     */
    public function getProduct(int $productId): ?ProductInterface
    {
        if (!array_key_exists($productId, $this->storage)) {
            $this->loadProducts([$productId]);
        }

        return $this->storage[$productId];
    }

    public function loadProducts(array $productIds): void
    {
        $productIds = array_diff($productIds, array_keys($this->storage));
        if (empty($productIds)) {
            return;
        }
        /** @var Collection $collection */
        $collection = $this->productCollectionFactory->create();
        $collection->addIdFilter($productIds);

        if ($this->isCategoryUsed()) {
            $collection->addCategoryIds();
        }

        /** @var Product $product */
        foreach ($collection->getItems() as $product) {
            $this->storage[$product->getId()] = $product;
        }

        foreach ($productIds as $productId) {
            if (!array_key_exists($productId, $this->storage)) {
                $this->storage[$productId] = null;
            }
        }
    }

    private function isCategoryUsed(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            \Magento\Catalog\Helper\Product::XML_PATH_PRODUCT_URL_USE_CATEGORY,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function _resetState(): void
    {
        $this->storage = [];
    }
}
