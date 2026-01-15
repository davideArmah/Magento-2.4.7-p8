<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Plugin\SeoRichData\Block;

use Armah\Meta\Helper\Data;
use Armah\SeoRichData\Model\JsonLd\ProductInfo;
use Magento\Catalog\Model\Product as ProductModel;

class Product
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var null|string
     */
    private $value = null;

    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param ProductInfo $subject
     * @param ProductModel $product
     * @param string $key
     *
     * @return array
     */
    public function beforeGetMetaData(ProductInfo $subject, ProductModel $product, string $key): array
    {
        if ($product && $key) {
            $metaData = $this->helper->observeProductPage($product, false);
            $this->value = isset($metaData[$key]) ? $metaData[$key] : '';
        }

        return [$product, $key];
    }

    /**
     * @param ProductInfo $subject
     * @param string $result
     *
     * @return string
     */
    public function afterGetMetaData(ProductInfo $subject, string $result): string
    {
        if ($this->value !== null) {
            $result = $this->value;
            $this->value = null;
        }

        return $result;
    }
}
