<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\Base\Model\ConfigProviderAbstract;

class ConfigProvider extends ConfigProviderAbstract
{
    /**
     * xpath prefix of module (section)
     * @var string '{section}/'
     */
    protected $pathPrefix = 'payment/';

    public const CASH_ON_DELIVERY_BLOCK = 'cashondelivery/';

    public const CASH_ON_DELIVERY_ENABLED = 'active';

    public const PAYMENT_FEE_ENABLED = 'enable_payment_fee';
    public const PAYMENT_FEE_LABEL = 'payment_fee_label';
    public const PAYMENT_FEE = 'payment_fee';
    public const PAYMENT_FEE_TYPE = 'payment_fee_type';

    public const PERCENT_CALCULATE_BASED_ON = 'payment_calculate_based_on';
    public const FIXED_CALCULATE_BASED_ON = 'payment_calculate_based_on_fixed';
    public const TAX_CLASS_FOR_FIXED = 'tax_class_for_fixed';
    public const DISPLAY_FEE_AT_CART = 'display_fee_at_cart';
    public const DISPLAY_FEE_AT_SALES = 'display_fee_at_sales';
    public const ALLOWED_SHIPPING = 'payment_shipping_allowspecific';
    public const SPECIFIC_SHIPPING = 'payment_shipping_specificcountry';

    public const CODE_VERIFICATION_ENABLED = 'enable_postcode_verification';
    public const VERIFICATION_TYPE = 'postcode_verification_type';
    public const ALLOWED_POSTAL_CODES = 'allowed_postal_codes';

    public const ORDER_STATUS = 'order_status';

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isPaymentFeeEnabled($storeId = null)
    {
        return $this->isSetFlag(self::CASH_ON_DELIVERY_BLOCK . self::PAYMENT_FEE_ENABLED, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isCashOnDeliveryEnabled($storeId = null)
    {
        return $this->isSetFlag(self::CASH_ON_DELIVERY_BLOCK . self::CASH_ON_DELIVERY_ENABLED, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isCodeVerificationEnabled($storeId = null)
    {
        return $this->isSetFlag(self::CASH_ON_DELIVERY_BLOCK . self::CODE_VERIFICATION_ENABLED, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return \Magento\Framework\Phrase
     */
    public function getPaymentFeeLabel($storeId = null)
    {
        $paymentFeeLabel = $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::PAYMENT_FEE_LABEL, $storeId)
            ?: 'Cash on Delivery Fee';

        return __($paymentFeeLabel);
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getPaymentFee($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::PAYMENT_FEE, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getAllowedShipping($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::ALLOWED_SHIPPING, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getSpecificShipping($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::SPECIFIC_SHIPPING, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getVerificationType($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::VERIFICATION_TYPE, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getAllowedPostalCodes($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::ALLOWED_POSTAL_CODES, $storeId);
    }

    /**
     * @return string
     */
    public function getOrderStatus()
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::ORDER_STATUS);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getPaymentFeeType($storeId = null)
    {
        return (int)$this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::PAYMENT_FEE_TYPE, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getPercentCalculateBasedOn($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::PERCENT_CALCULATE_BASED_ON, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getFixedCalculateBasedOn($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::FIXED_CALCULATE_BASED_ON, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getTaxClassForFixedFee($storeId = null)
    {
        return $this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::TAX_CLASS_FOR_FIXED, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getDisplayFeeAtCart(int $storeId = null): int
    {
        return (int)$this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::DISPLAY_FEE_AT_CART, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return int
     */
    public function getDisplayFeeAtSales(int $storeId = null): int
    {
        return (int)$this->getValue(self::CASH_ON_DELIVERY_BLOCK . self::DISPLAY_FEE_AT_SALES, $storeId);
    }
}
