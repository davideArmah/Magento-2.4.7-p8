<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Hyva\StripeIntegrationPayments\Plugin\Magento\Catalog\Block;

use Psr\Log\LoggerInterface as Logger;
use StripeIntegration\Payments\Block\Minicart\Shortcut;

class ShortcutButtons
{
    const TEMPLATE_CART_BUTTON = 'Hyva_StripeIntegrationPayments::express/cart_button.phtml';
    const TEMPLATE_MINICART_BUTTON = 'Hyva_StripeIntegrationPayments::express/minicart_button.phtml';

    /**
     * @var Logger
     */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    public function beforeAddShortcut(
        \Magento\Catalog\Block\ShortcutButtons $subject,
        $block
    ) {
        if(!$block instanceof Shortcut) {
            return [$block];
        }

        try {
            if ($subject->getNameInLayout() == 'shortcutbuttons_0') {
                // Minicart button
                $block->setTemplate(self::TEMPLATE_MINICART_BUTTON);

                return [$block];
            }

            // Cart button
            $block->setTemplate(self::TEMPLATE_CART_BUTTON);
        } catch (\Exception $exception) {
            $this->_logger->error($exception->getMessage());
        }

        return [$block];
    }

}
