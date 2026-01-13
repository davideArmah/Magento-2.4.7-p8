<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

interface AdditionalFieldsManagementInterface
{
    /**
     * @param int $cartId
     * @param \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface $fields
     *
     * @return bool
     */
    public function save($cartId, $fields);

    /**
     * @param int $quoteId
     *
     * @return \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface|\Armah\CheckoutCore\Model\AdditionalFields
     */
    public function getByQuoteId($quoteId);
}
