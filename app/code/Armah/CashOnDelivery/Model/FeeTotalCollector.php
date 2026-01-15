<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Model\Config\Source\PaymentFeeTypes;
use Magento\Framework\DataObject;
use Magento\Tax\Model\Config;

class FeeTotalCollector
{
    public const FEE_CODE = 'armah_cash_on_delivery_fee';

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @param OrderPaymentFee $paymentFee
     * @param int $storeId
     * @return DataObject[]
     */
    public function getTotals(OrderPaymentFee $paymentFee, int $storeId): array
    {
        $totals = [];
        if ($this->configProvider->getPaymentFeeType($storeId) === PaymentFeeTypes::FIXED_AMOUNT) {
            $totals = $this->getFeeTotalsByStrategy($paymentFee, $storeId);
        } else {
            $amount = $paymentFee->getAmount();
            $baseAmount = $paymentFee->getBaseAmount();
            $totals[] = $this->createTotal(self::FEE_CODE, '', $amount, $baseAmount, $storeId);
        }

        return $totals;
    }

    /**
     * @param OrderPaymentFee $paymentFee
     * @param int $storeId
     * @return DataObject[]
     */
    private function getFeeTotalsByStrategy(OrderPaymentFee $paymentFee, int $storeId): array
    {
        $totals = [];
        $amount = $paymentFee->getAmount();
        $baseAmount = $paymentFee->getBaseAmount();
        $displayMode = $this->configProvider->getDisplayFeeAtSales($storeId);
        if ($displayMode === Config::DISPLAY_TYPE_BOTH || $displayMode === Config::DISPLAY_TYPE_EXCLUDING_TAX) {
            $totals[] = $this->createTotal(
                self::FEE_CODE . '_excl_tax',
                (string) __(' (Excl. Tax)'),
                $amount,
                $baseAmount,
                $storeId
            );
        }
        if ($displayMode === Config::DISPLAY_TYPE_BOTH || $displayMode === Config::DISPLAY_TYPE_INCLUDING_TAX) {
            $amount += $paymentFee->getTaxAmount();
            $baseAmount += $paymentFee->getBaseTaxAmount();
            $totals[] = $this->createTotal(
                self::FEE_CODE . '_incl_tax',
                (string) __(' (Incl. Tax)'),
                $amount,
                $baseAmount,
                $storeId
            );
        }

        return $totals;
    }

    private function createTotal(
        string $code,
        string $taxDisplay,
        float $amount,
        float $baseAmount,
        int $storeId
    ): DataObject {
        return new DataObject(
            [
                'code' => $code,
                'strong' => false,
                'value' => +$amount,
                'base_value' => +$baseAmount,
                'label' => __('%1 %2', $this->configProvider->getPaymentFeeLabel($storeId), $taxDisplay)
            ]
        );
    }
}
