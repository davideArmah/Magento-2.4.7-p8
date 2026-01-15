<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Config;

use Armah\CheckoutCore\Api\CheckoutBlocksProviderInterface;
use Armah\CheckoutCore\Model\Config\Source\Layout;
use Armah\CheckoutCore\ViewModel\StyleSwitcherProvider;

class CheckoutBlocksProvider implements CheckoutBlocksProviderInterface
{
    /**
     * @var StyleSwitcherProvider
     */
    private $styleSwitcherProvider;

    public function __construct(StyleSwitcherProvider $styleSwitcherProvider)
    {
        $this->styleSwitcherProvider = $styleSwitcherProvider;
    }

    /**
     * @return array
     */
    public function getDefaultBlockTitles(): array
    {
        return [
            'shipping_address' => __('Shipping Address'),
            'shipping_method' => __('Shipping Method'),
            'payment_method' => __('Payment Method'),
            'summary' => __('Order Summary'),
        ];
    }

    /**
     * Method for provide default Layout Builder configs.
     * $store used in submodule.
     *
     * @param ?int $store
     * @return array
     */
    public function getBlocksConfig(?int $store = null): array
    {
        if ($this->styleSwitcherProvider->getDesignLayout() === Layout::THREE_COLUMNS) {
            return $this->getThreeColumnsDefaultLayout();
        }

        return $this->getTwoColumnsDefaultLayout();
    }

    /**
     * @return array
     */
    private function getTwoColumnsDefaultLayout(): array
    {
        return [
            [
                [
                    'name' => 'shipping_address',
                    'title' => '',
                ],
                [
                    'name' => 'shipping_method',
                    'title' => '',
                ],
                [
                    'name' => 'delivery',
                    'title' => '',
                ]
            ],
            [
                [
                    'name' => 'payment_method',
                    'title' => '',
                ],
                [
                    'name' => 'summary',
                    'title' => '',
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getThreeColumnsDefaultLayout(): array
    {
        return [
            [
                [
                    'name' => 'shipping_address',
                    'title' => '',
                ],
            ],
            [
                [
                    'name' => 'shipping_method',
                    'title' => '',
                ],
                [
                    'name' => 'delivery',
                    'title' => '',
                ],
                [
                    'name' => 'payment_method',
                    'title' => '',
                ]
            ],
            [
                [
                    'name' => 'summary',
                    'title' => '',
                ]
            ]
        ];
    }
}
