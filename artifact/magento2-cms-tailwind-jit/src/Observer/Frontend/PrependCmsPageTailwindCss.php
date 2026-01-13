<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Observer\Frontend;

use Hyva\CmsTailwindJit\Model\CmsEntityTailwindCssRepository;
use Hyva\CmsTailwindJit\Model\PrefixJitClasses;
use Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCmsPageTailwindCss;
use Hyva\Theme\Service\CurrentTheme;
use Magento\Cms\Model\Page;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PrependCmsPageTailwindCss implements ObserverInterface
{
    /**
     * @var CmsEntityTailwindCssRepository
     */
    private $cmsEntityTailwindCssRepository;

    /**
     * @var CurrentTheme
     */
    private $currentTheme;

    /**
     * @var PrefixJitClasses
     */
    private $prefixJitClasses;

    public function __construct(
        CmsEntityTailwindCssRepository $cmsEntityTailwindCssRepository,
        CurrentTheme $currentTheme,
        PrefixJitClasses $prefixJitClasses
    ) {
        $this->cmsEntityTailwindCssRepository = $cmsEntityTailwindCssRepository;
        $this->currentTheme                   = $currentTheme;
        $this->prefixJitClasses               = $prefixJitClasses;
    }

    public function execute(Event $event)
    {
        if (!$this->currentTheme->isHyva()) {
            return;
        }
        /** @var Page $page */
        $page = $event->getData('object');

        $table = PersistCmsPageTailwindCss::TABLE;
        if ($styles = $this->cmsEntityTailwindCssRepository->loadStyles($table, (int) $page->getId())) {
            $this->prefixGeneratedStyles($styles, $page);
        }
    }

    private function prefixGeneratedStyles(string $styles, Page $page): void
    {
        $prefix     = 'cmsp' . $page->getId() . '-';
        $newContent = sprintf(
            "<style>%s</style>\n%s",
            $this->prefixJitClasses->prefixJitClassesInCss($styles, $prefix),
            $this->prefixJitClasses->prefixJitClassesInHtml($styles, $page->getContent(), $prefix)
        );
        $page->setContent($newContent);
    }
}
