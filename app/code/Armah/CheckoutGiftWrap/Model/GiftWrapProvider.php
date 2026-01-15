<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Amasty (https://www.armah.it)
 * @package One Step Checkout Gift Wrap for Magento 2 (System)
 */

namespace Armah\CheckoutGiftWrap\Model;

use Armah\CheckoutCore\Api\GiftWrapProviderInterface;

class GiftWrapProvider implements GiftWrapProviderInterface
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
     * @return bool
     */
    public function isGiftWrapEnabled(): bool
    {
        return $this->configProvider->isGiftWrapEnabled();
    }

    /**
     * @return float
     */
    public function getGiftWrapFee(): float
    {
        return $this->configProvider->getGiftWrapFee();
    }
}
