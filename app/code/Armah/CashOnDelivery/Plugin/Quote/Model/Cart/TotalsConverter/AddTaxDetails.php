<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Plugin\Quote\Model\Cart\TotalsConverter;

use Armah\CashOnDelivery\Api\TaxFeeDetailsInterfaceFactory;
use Magento\Quote\Api\Data\TotalSegmentExtensionFactory;
use Magento\Quote\Model\Cart\TotalsConverter;

class AddTaxDetails
{
    public const FEE_CODE = 'armah_cash_on_delivery_fee';

    /**
     * @var TotalSegmentExtensionFactory
     */
    private $totalSegmentExtensionFactory;

    /**
     * @var TaxFeeDetailsInterfaceFactory
     */
    private $taxFeeDetailsFactory;

    public function __construct(
        TotalSegmentExtensionFactory $totalSegmentExtensionFactory,
        TaxFeeDetailsInterfaceFactory $taxFeeDetailsFactory
    ) {
        $this->totalSegmentExtensionFactory = $totalSegmentExtensionFactory;
        $this->taxFeeDetailsFactory = $taxFeeDetailsFactory;
    }

    /**
     * @param TotalsConverter $subject
     * @param array $totalSegments
     * @param array $addressTotals
     * @return array
     */
    public function afterProcess(
        TotalsConverter $subject,
        array $totalSegments,
        array $addressTotals = []
    ) {
        if (!array_key_exists(self::FEE_CODE, $addressTotals)) {
            return $totalSegments;
        }

        $taxFeeDetails = $this->taxFeeDetailsFactory->create();
        $taxFeeDetails->setValueInclTax((float)$addressTotals[self::FEE_CODE]['value_incl_tax']);
        $taxFeeDetails->setValueExclTax((float)$addressTotals[self::FEE_CODE]['value_excl_tax']);

        $attributes = $totalSegments[self::FEE_CODE]->getExtensionAttributes();

        if ($attributes === null) {
            $attributes = $this->totalSegmentExtensionFactory->create();
        }
        $attributes->setTaxArmahCodFeeDetails($taxFeeDetails);
        $totalSegments[self::FEE_CODE]->setExtensionAttributes($attributes);

        return $totalSegments;
    }
}
