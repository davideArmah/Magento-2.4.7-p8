<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $config = [];
        $config['armah'] = [
            'cashOnDelivery' => [
                'paymentFeeType' => $this->configProvider->getPaymentFeeType(),
                'displayPriceMode' => $this->configProvider->getDisplayFeeAtCart()
            ]
        ];

        return $config;
    }
}
