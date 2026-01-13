<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Observer\Adminhtml;

use Hyva\CmsTailwindJit\Model\CmsEntityTailwindCssRepository;
use Magento\Catalog\Model\Category;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PersistCategoryTailwindCss implements ObserverInterface
{
    const TABLE = 'hyva_catalog_category_tailwindcss';

    /**
     * @var CmsEntityTailwindCssRepository
     */
    private $cmsEntityTailwindCssRepository;

    public function __construct(CmsEntityTailwindCssRepository $cmsEntityTailwindCssRepository)
    {
        $this->cmsEntityTailwindCssRepository = $cmsEntityTailwindCssRepository;
    }

    public function execute(Event $event)
    {
        /** @var Category $category */
        $category         = $event->getData('category');
        $themeToStylesMap = $category->getData('tailwindcss') ?? [];

        $this->cmsEntityTailwindCssRepository->saveStyles(self::TABLE, (int) $category->getId(), $themeToStylesMap);
    }
}
