<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Model\ResourceModel\PaymentFee as PaymentFeeResource;
use Magento\Framework\Model\AbstractModel;
use Armah\CashOnDelivery\Api\Data\PaymentFeeInterface;

class PaymentFee extends AbstractModel implements PaymentFeeInterface
{
    public function _construct()
    {
        $this->_init(PaymentFeeResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getQuoteId()
    {
        return $this->_getData(PaymentFeeInterface::QUOTE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setQuoteId($quoteId)
    {
        $this->setData(PaymentFeeInterface::QUOTE_ID, $quoteId);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAmount()
    {
        return (float)$this->_getData(PaymentFeeInterface::AMOUNT);
    }

    /**
     * @inheritdoc
     */
    public function setAmount($amount)
    {
        $this->setData(PaymentFeeInterface::AMOUNT, $amount);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBaseAmount()
    {
        return (float)$this->_getData(PaymentFeeInterface::BASE_AMOUNT);
    }

    /**
     * @inheritdoc
     */
    public function setBaseAmount($baseAmount)
    {
        $this->setData(PaymentFeeInterface::BASE_AMOUNT, $baseAmount);

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxAmount(): float
    {
        return (float)$this->_getData(PaymentFeeInterface::TAX_AMOUNT);
    }

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount(float $taxAmount): void
    {
        $this->setData(PaymentFeeInterface::TAX_AMOUNT, $taxAmount);
    }

    /**
     * @return float
     */
    public function getBaseTaxAmount(): float
    {
        return (float)$this->_getData(PaymentFeeInterface::BASE_TAX_AMOUNT);
    }

    /**
     * @param float $baseTaxAmount
     */
    public function setBaseTaxAmount(float $baseTaxAmount): void
    {
        $this->setData(PaymentFeeInterface::BASE_TAX_AMOUNT, $baseTaxAmount);
    }
}
