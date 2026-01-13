<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Amasty (https://www.armah.it)
 * @package One Step Checkout Gift Wrap for Magento 2 (System)
 */

namespace Armah\CheckoutGiftWrap\Api;

interface GuestGiftMessageInformationManagementInterface
{
    /**
     * @param string $cartId
     * @param mixed $giftMessage
     *
     * @return bool
     */
    public function update($cartId, $giftMessage): bool;
}
