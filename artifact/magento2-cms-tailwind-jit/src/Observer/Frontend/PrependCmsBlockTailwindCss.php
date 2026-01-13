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
use Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCmsBlockTailwindCss;
use Hyva\Theme\Service\CurrentTheme;
use Magento\Cms\Model\Block;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PrependCmsBlockTailwindCss implements ObserverInterface
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
        /** @var Block $block */
        $block = $event->getData('object');

        $table = PersistCmsBlockTailwindCss::TABLE;
        if ($styles = $this->cmsEntityTailwindCssRepository->loadStyles($table, (int) $block->getId())) {
            $this->prefixGeneratedStyles($styles, $block);
        }
    }

    private function prefixGeneratedStyles(string $styles, Block $block): void
    {
        $prefix     = 'cmsb' . $block->getId() . '-';
        $newContent = sprintf(
            "<style>%s</style>\n%s",
            $this->prefixJitClasses->prefixJitClassesInCss($styles, $prefix),
            $this->prefixJitClasses->prefixJitClassesInHtml($styles, $block->getContent(), $prefix)
        );
        $block->setContent($newContent);
    }
}
