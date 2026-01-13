<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api\Data;

interface OrderPaymentFeeInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const ENTITY_ID = 'entity_id';
    public const ORDER_ID = 'order_id';
    public const AMOUNT = 'amount';
    public const BASE_AMOUNT = 'base_amount';
    public const TAX_AMOUNT = 'tax_amount';
    public const BASE_TAX_AMOUNT = 'base_tax_amount';

    /**
     * @return int
     */
    public function getEntityFeeId(): int;

    /**
     * @param int $entityId
     * @return void
     */
    public function setEntityFeeId(int $entityId): void;

    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $orderId
     * @return void
     */
    public function setOrderId(int $orderId): void;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @param float $amount
     * @return void
     */
    public function setAmount(float $amount): void;

    /**
     * @return float
     */
    public function getBaseAmount(): float;

    /**
     * @param float $baseAmount
     * @return void
     */
    public function setBaseAmount(float $baseAmount): void;

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
