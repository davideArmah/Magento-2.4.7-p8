<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

interface GuestAdditionalFieldsManagementInterface
{
    /**
     * @param string $cartId
     * @param \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface $fields
     *
     * @return bool
     */
    public function save($cartId, $fields);
}
