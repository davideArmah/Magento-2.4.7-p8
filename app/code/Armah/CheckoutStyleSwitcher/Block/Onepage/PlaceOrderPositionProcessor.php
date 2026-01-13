<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Style Switcher for Magento 2 (System)
 */

namespace Armah\CheckoutStyleSwitcher\Block\Onepage;

use Armah\CheckoutCore\Block\Onepage\LayoutWalker;
use Armah\CheckoutCore\Block\Onepage\LayoutWalkerFactory;
use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutStyleSwitcher\Model\Config\Source\PlaceButtonLayout;
use Armah\CheckoutStyleSwitcher\Model\ConfigProvider;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

/**
 * Additional Layout processor with all private and dynamic data
 */
class PlaceOrderPositionProcessor implements LayoutProcessorInterface
{
    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var LayoutWalker
     */
    private $walker;

    /**
     * @var LayoutWalkerFactory
     */
    private $walkerFactory;

    public function __construct(
        Config $checkoutConfig,
        ConfigProvider $configProvider,
        LayoutWalkerFactory $walkerFactory
    ) {
        $this->checkoutConfig = $checkoutConfig;
        $this->configProvider = $configProvider;
        $this->walkerFactory = $walkerFactory;
    }

    public function process($jsLayout)
    {
        if (!$this->checkoutConfig->isEnabled()) {
            return $jsLayout;
        }
        $this->walker = $this->walkerFactory->create(['layoutArray' => $jsLayout]);

        $this->walker->setValue('{CHECKOUT}.config.additionalClasses', $this->getAdditionalCheckoutClasses());

        return $this->walker->getResult();
    }

    /**
     * @return string
     */
    private function getAdditionalCheckoutClasses(): string
    {
        $position = $this->configProvider->getPlaceOrderPosition();
        $frontClasses = '';
        switch ($position) {
            case PlaceButtonLayout::FIXED_TOP:
                $frontClasses .= ' am-submit-fixed -top';
                break;
            case PlaceButtonLayout::FIXED_BOTTOM:
                $frontClasses .= ' am-submit-fixed -bottom';
                break;
            case PlaceButtonLayout::SUMMARY:
                $frontClasses .= ' am-submit-summary';
                $this->walker->setValue(
                    '{SIDEBAR}.>>.place-button.component',
                    'Armah_CheckoutStyleSwitcher/js/view/place-button'
                );
                break;
        }

        return $frontClasses;
    }
}
