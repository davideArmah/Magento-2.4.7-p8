<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Armah\CheckoutCore\Model\OrderCustomFields::class,
            \Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields::class
        );
    }

    /**
     * @param int $orderId
     *
     * @return Collection
     */
    public function addFieldByOrderId($orderId)
    {
        return $this->addFieldToFilter(OrderCustomFieldsInterface::ORDER_ID, $orderId);
    }

    /**
     * @param int $orderId
     * @param string $customFieldIndex
     *
     * @return Collection
     */
    public function addFieldByOrderIdAndCustomField($orderId, $customFieldIndex)
    {
        return $this->addFieldByOrderId($orderId)
            ->addFieldToFilter(OrderCustomFieldsInterface::NAME, $customFieldIndex);
    }
}
