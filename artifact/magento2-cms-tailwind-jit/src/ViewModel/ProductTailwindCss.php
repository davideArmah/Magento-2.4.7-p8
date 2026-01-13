<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\ViewModel;

use Hyva\CmsTailwindJit\Model\CmsEntityTailwindCssRepository;
use Hyva\CmsTailwindJit\Model\PrefixJitClasses;
use Hyva\CmsTailwindJit\Observer\Adminhtml\PersistProductTailwindCss as ProductStyles;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class ProductTailwindCss implements ArgumentInterface
{
    /**
     * @var CmsEntityTailwindCssRepository
     */
    private $cmsEntityTailwindCssRepository;

    /**
     * @var PrefixJitClasses
     */
    private $prefixJitClasses;

    public function __construct(
        CmsEntityTailwindCssRepository $cmsEntityTailwindCssRepository,
        PrefixJitClasses $prefixJitClasses
    ) {
        $this->cmsEntityTailwindCssRepository = $cmsEntityTailwindCssRepository;
        $this->prefixJitClasses = $prefixJitClasses;
    }

    public function getStyles(ProductInterface $product): string
    {
        $styles = $this->cmsEntityTailwindCssRepository->loadStyles(ProductStyles::TABLE, (int) $product->getId());
        return $styles && $product instanceof Product
            ? $this->prefixProductCmsTailwindCssJitClasses($product, $styles)
            : $styles;
    }

    private function prefixProductCmsTailwindCssJitClasses(Product $product, string $styles): string
    {
        $prefix = 'cp' . $product->getId() . '_';
        if ($shortDescription = $product->getData('short_description')) {
            $product->setData(
                'short_description',
                $this->prefixJitClasses->prefixJitClassesInHtml($styles, $shortDescription, $prefix)
            );
        }
        if ($description = $product->getData('description')) {
            $product->setData(
                'description',
                $this->prefixJitClasses->prefixJitClassesInHtml($styles, $description, $prefix)
            );
        }
        return $this->prefixJitClasses->prefixJitClassesInCss($styles, $prefix);
    }
}
