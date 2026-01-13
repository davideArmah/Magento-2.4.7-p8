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
use Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCategoryTailwindCss as CategoryStyles;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CategoryTailwindCss implements ArgumentInterface
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

    public function getStyles(CategoryInterface $category): string
    {
        return $this->getStylesForCategoryAttributes($category, ['description']);
    }

    public function getStylesForCategoryAttributes(CategoryInterface $category, array $attributeCodes): string
    {
        $styles = $this->cmsEntityTailwindCssRepository->loadStyles(CategoryStyles::TABLE, (int) $category->getId());
        return $styles && $category instanceof Category
            ? $this->prefixCategoryCmsTailwindCssJitClasses($category, $styles, $attributeCodes)
            : $styles;
    }

    private function prefixCategoryCmsTailwindCssJitClasses(Category $category, string $styles, array $attributeCodes): string
    {
        $prefix = 'cc' . $category->getId() . '-';
        $twStylesPresent = false;

        foreach ($attributeCodes as $attributeCode) {
            if ($attributeValue = $category->getData($attributeCode)) {
                // Apply JIT class prefixing to the attribute data.
                $processedData = $this->prefixJitClasses->prefixJitClassesInHtml($styles, $attributeValue, $prefix);
                // Set the processed data back on the category object.
                $category->setData($attributeCode, $processedData);
                $twStylesPresent = true;
            }
        }

        return $twStylesPresent
            ? $this->prefixJitClasses->prefixJitClassesInCss($styles, $prefix)
            : $styles;
    }
}
