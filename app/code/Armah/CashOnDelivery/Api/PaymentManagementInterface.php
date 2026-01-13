<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api;

interface PaymentManagementInterface
{

    /**
     * Check cash on delivery for available
     *
     * @param string $postalCode ZIP code.
     * @return bool
     */
    public function checkAvailable($postalCode);
}
