<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Layout Builder for Magento 2 (System)
 */

namespace Armah\CheckoutLayoutBuilder\Model\Config;

use Armah\CheckoutCore\Api\CheckoutBlocksProviderInterface;
use Armah\CheckoutLayoutBuilder\Model\ConfigProvider;

class CheckoutBlocksProvider implements CheckoutBlocksProviderInterface
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
    public function getDefaultBlockTitles(): array
    {
        return [
            'shipping_address' => __('Shipping Address'),
            'shipping_method' => __('Shipping Method'),
            'delivery' => __('Delivery'),
            'payment_method' => __('Payment Method'),
            'summary' => __('Order Summary'),
        ];
    }

    /**
     * @param ?int $store
     * @return array
     */
    public function getBlocksConfig(?int $store = null): array
    {
        return $this->configProvider->getCheckoutBlocksConfig($store);
    }
}
