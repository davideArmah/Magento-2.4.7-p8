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
use Magento\Cms\Model\Block;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PersistCmsBlockTailwindCss implements ObserverInterface
{
    const TABLE = 'hyva_cms_block_tailwindcss';

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
        /** @var Block $block */
        $block = $event->getData('object');

        $themeToStylesMap = $block->getData('tailwindcss') ?? [];

        $this->cmsEntityTailwindCssRepository->saveStyles(self::TABLE, (int) $block->getId(), $themeToStylesMap);
    }
}
