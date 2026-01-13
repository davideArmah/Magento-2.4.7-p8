<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Sales\Api\Data\OrderInterface;

interface AccountManagementInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return bool|CustomerInterface
     */
    public function createAccount($order);

    /**
     * @param string $cartId
     * @param string $password
     *
     * @return boolean
     */
    public function savePassword($cartId, $password);

    /**
     * @param OrderInterface $order
     *
     * @return boolean
     */
    public function deletePassword($order);
}
