<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Api\TaxFeeDetailsInterface;
use Magento\Framework\DataObject;

class TaxFeeDetails extends DataObject implements TaxFeeDetailsInterface
{
    /**
     * @return float|null
     */
    public function getValueExclTax(): ?float
    {
        return $this->getData(TaxFeeDetailsInterface::VALUE_EXCL_TAX);
    }

    /**
     * @param float $amountExclTax
     * @return TaxFeeDetailsInterface
     */
    public function setValueExclTax(float $amountExclTax): TaxFeeDetailsInterface
    {
        return $this->setData(TaxFeeDetailsInterface::VALUE_EXCL_TAX, $amountExclTax);
    }

    /**
     * @return float|null
     */
    public function getValueInclTax(): ?float
    {
        return $this->getData(TaxFeeDetailsInterface::VALUE_INCL_TAX);
    }

    /**
     * @param float $amountInclTax
     * @return TaxFeeDetailsInterface
     */
    public function setValueInclTax(float $amountInclTax): TaxFeeDetailsInterface
    {
        return $this->setData(TaxFeeDetailsInterface::VALUE_INCL_TAX, $amountInclTax);
    }
}
