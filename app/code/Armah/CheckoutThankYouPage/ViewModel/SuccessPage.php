<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Thank you Page 2 for Magento 2 (System)
 */

namespace Armah\CheckoutThankYouPage\ViewModel;

use Armah\CheckoutCore\Model\Config as CheckoutCoreConfig;
use Armah\CheckoutThankYouPage\Model\Config;
use Armah\CheckoutThankYouPage\Model\ThankYouPageModule;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class SuccessPage implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $confug;

    /**
     * @var CheckoutCoreConfig
     */
    private $checkoutCoreConfig;

    /**
     * @var ThankYouPageModule
     */
    private $thankYouPageModule;

    public function __construct(
        Config $config,
        CheckoutCoreConfig $checkoutCoreConfig,
        ThankYouPageModule $thankYouPageModule
    ) {
        $this->confug = $config;
        $this->checkoutCoreConfig = $checkoutCoreConfig;
        $this->thankYouPageModule = $thankYouPageModule;
    }

    public function isEnable(): bool
    {
        return $this->confug->isCustomPageEnable()
            && $this->checkoutCoreConfig->isEnabled()
            && $this->isShouldShowByThankYouPageModule();
    }

    public function isShouldShowByThankYouPageModule(): bool
    {
        return !$this->thankYouPageModule->isModuleEnable();
    }
}
