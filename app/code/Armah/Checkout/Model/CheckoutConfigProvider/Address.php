<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Model\CheckoutConfigProvider;

use Armah\Checkout\Model\Config;
use Armah\Checkout\Model\Config\Source\Address as SourceAddress;
use Magento\Checkout\Model\ConfigProviderInterface;

class Address implements ConfigProviderInterface
{
    public const IS_BILLING_SAME_AS_SHIPPING = 'isBillingSameAsShipping';
    public const DISPLAY_BILLING_SAME_AS_SHIPPING = 'displayBillingSameAsShipping';

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }
    
    /**
     * @return array
     */
    public function getConfig(): array
    {
        $addressCheckboxState = $this->config->getAddressCheckboxState();
        return [
            static::IS_BILLING_SAME_AS_SHIPPING => $addressCheckboxState === SourceAddress::CHECKED,
            static::DISPLAY_BILLING_SAME_AS_SHIPPING => $addressCheckboxState !== SourceAddress::HIDDEN
        ];
    }
}
