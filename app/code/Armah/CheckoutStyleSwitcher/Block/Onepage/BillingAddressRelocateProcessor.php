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
use Armah\CheckoutStyleSwitcher\Model\ConfigProvider;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Additional Layout processor with all private and dynamic data
 */
class BillingAddressRelocateProcessor implements LayoutProcessorInterface
{
    public const BILLING_ADDRESS_POSITION = 2;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

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
        CheckoutSession $checkoutSession,
        Config $checkoutConfig,
        ConfigProvider $configProvider,
        LayoutWalkerFactory $walkerFactory
    ) {
        $this->checkoutSession = $checkoutSession;
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

        if (!$this->checkoutSession->getQuote()->isVirtual()) {
            $this->processBillingAddressRelocation();
        }

        return $this->walker->getResult();
    }

    /**
     * Transfer billing address from Payment to Shipping Address section
     */
    private function processBillingAddressRelocation()
    {
        if ($this->configProvider->getBillingAddressDisplayOn() == self::BILLING_ADDRESS_POSITION) {
            $billingAddress = $this->walker->getValue('{PAYMENT}.>>.afterMethods.>>.billing-address-form');
            $this->walker->setValue('{SHIPPING_ADDRESS}.>>.billing-address-form', $billingAddress);

            $afterMethodsChilds = $this->walker->getValue('{PAYMENT}.>>.afterMethods.>>');
            unset($afterMethodsChilds['billing-address-form']);
            $this->walker->setValue('{PAYMENT}.>>.afterMethods.>>', $afterMethodsChilds);
        }
    }
}
