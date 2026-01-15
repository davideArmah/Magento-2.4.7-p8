<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\GiftWrapProviderInterface;

/**
 * Provide data to GraphQl submodule
 */
class GiftWrapProvider implements GiftWrapProviderInterface
{
    /**
     * @return bool
     */
    public function isGiftWrapEnabled(): bool
    {
        return false;
    }

    /**
     * @return float
     */
    public function getGiftWrapFee(): float
    {
        return 0.0;
    }
}
