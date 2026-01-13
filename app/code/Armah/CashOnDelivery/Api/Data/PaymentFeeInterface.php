<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api\Data;

interface PaymentFeeInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const ENTITY_ID = 'entity_id';
    public const QUOTE_ID = 'quote_id';
    public const AMOUNT = 'amount';
    public const BASE_AMOUNT = 'base_amount';
    public const TAX_AMOUNT = 'tax_amount';
    public const BASE_TAX_AMOUNT = 'base_tax_amount';

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     */
    public function setEntityId($entityId);

    /**
     * @return int|null
     */
    public function getQuoteId();

    /**
     * @param int|null $quoteId
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     */
    public function setQuoteId($quoteId);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param float $amount
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     */
    public function setAmount($amount);

    /**
     * @return float
     */
    public function getBaseAmount();

    /**
     * @param float $baseAmount
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     */
    public function setBaseAmount($baseAmount);

    /**
     * @return float
     */
    public function getTaxAmount(): float;

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount(float $taxAmount): void;

    /**
     * @return float
     */
    public function getBaseTaxAmount(): float;

    /**
     * @param float $baseTaxAmount
     */
    public function setBaseTaxAmount(float $baseTaxAmount): void;
}
