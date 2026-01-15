<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;
use Magento\Framework\Model\AbstractModel;

class OrderCustomFields extends AbstractModel implements OrderCustomFieldsInterface
{
    protected function _construct()
    {
        $this->_init(\Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId($id)
    {
        $this->setData(self::ORDER_ID, $id);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingValue()
    {
        return $this->getData(self::BILLING_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingValue($value)
    {
        $this->setData(self::BILLING_VALUE, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingValue()
    {
        return $this->getData(self::SHIPPING_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingValue($value)
    {
        $this->setData(self::SHIPPING_VALUE, $value);

        return $this;
    }
}
