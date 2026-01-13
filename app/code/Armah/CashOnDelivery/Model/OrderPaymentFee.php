<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Api\Data\OrderPaymentFeeInterface;
use Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee as OrderPaymentFeeResource;
use Magento\Framework\Model\AbstractModel;

class OrderPaymentFee extends AbstractModel implements OrderPaymentFeeInterface
{
    public function _construct()
    {
        $this->_init(OrderPaymentFeeResource::class);
    }

    /**
     * @return int
     */
    public function getEntityFeeId(): int
    {
        return (int)$this->_getData(OrderPaymentFeeInterface::ENTITY_ID);
    }

    /**
     * @param int $entityId
     */
    public function setEntityFeeId(int $entityId): void
    {
        $this->setData(OrderPaymentFeeInterface::ENTITY_ID, $entityId);
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return (int)$this->_getData(OrderPaymentFeeInterface::ORDER_ID);
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->setData(OrderPaymentFeeInterface::ORDER_ID, $orderId);
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float)$this->_getData(OrderPaymentFeeInterface::AMOUNT);
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->setData(OrderPaymentFeeInterface::AMOUNT, $amount);
    }

    /**
     * @return float
     */
    public function getBaseAmount(): float
    {
        return (float)$this->_getData(OrderPaymentFeeInterface::BASE_AMOUNT);
    }

    /**
     * @param float $baseAmount
     */
    public function setBaseAmount(float $baseAmount): void
    {
        $this->setData(OrderPaymentFeeInterface::BASE_AMOUNT, $baseAmount);
    }

    /**
     * @return float
     */
    public function getTaxAmount(): float
    {
        return (float)$this->_getData(OrderPaymentFeeInterface::TAX_AMOUNT);
    }

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount(float $taxAmount): void
    {
        $this->setData(OrderPaymentFeeInterface::TAX_AMOUNT, $taxAmount);
    }

    /**
     * @return float
     */
    public function getBaseTaxAmount(): float
    {
        return (float)$this->_getData(OrderPaymentFeeInterface::BASE_TAX_AMOUNT);
    }

    /**
     * @param float $baseTaxAmount
     */
    public function setBaseTaxAmount(float $baseTaxAmount): void
    {
        $this->setData(OrderPaymentFeeInterface::BASE_TAX_AMOUNT, $baseTaxAmount);
    }
}
