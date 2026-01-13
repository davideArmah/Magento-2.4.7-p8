<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

use Magento\Quote\Api\Data\AddressInterface;

interface ItemManagementInterface
{
    /**
     * @param int              $cartId
     * @param int              $itemId
     * @param AddressInterface $address
     *
     * @return \Armah\CheckoutCore\Api\Data\TotalsInterface|boolean
     */
    public function remove($cartId, $itemId, AddressInterface $address);

    /**
     * @param int              $cartId
     * @param int              $itemId
     * @param string           $formData
     *
     * @return \Armah\CheckoutCore\Api\Data\TotalsInterface|boolean
     */
    public function update($cartId, $itemId, $formData);
}
