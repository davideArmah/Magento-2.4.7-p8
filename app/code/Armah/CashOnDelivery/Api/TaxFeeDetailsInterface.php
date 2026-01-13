<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api;

use Magento\Framework\Api\ExtensibleDataInterface;

interface TaxFeeDetailsInterface extends ExtensibleDataInterface
{
    public const VALUE_INCL_TAX = 'value_incl_tax';
    public const VALUE_EXCL_TAX = 'value_excl_tax';

    /**
     * @return float|null
     */
    public function getValueInclTax(): ?float;

    /**
     * @param float $amountInclTax
     * @return TaxFeeDetailsInterface
     */
    public function setValueInclTax(float $amountInclTax): TaxFeeDetailsInterface;

    /**
     * @return float|null
     */
    public function getValueExclTax(): ?float;

    /**
     * @param float $amountExclTax
     * @return TaxFeeDetailsInterface
     */
    public function setValueExclTax(float $amountExclTax): TaxFeeDetailsInterface;
}
