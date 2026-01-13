<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Observer\Adminhtml;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

class SetDefaultProductJitEnabled implements ObserverInterface
{
    public function execute(Event $event)
    {
        /** @var Product $product */
        $product = $event->getData('product');
        if (null === $product->getData('is_tailwindcss_jit_enabled')) {
            $product->setData('is_tailwindcss_jit_enabled', '1');
        }
    }
}
