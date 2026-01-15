<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Model\ConfigProvider;
use Magento\Customer\Model\Address\AbstractAddress;
use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Quote\Api\Data\CartInterface;

class PaymentValidator
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @param CartInterface $quote
     *
     * @return bool
     */
    public function validatePaymentFee(CartInterface $quote)
    {
        $storeId = $quote->getStoreId();
        if (!$this->configProvider->isPaymentFeeEnabled($storeId)
            || !$this->configProvider->isCashOnDeliveryEnabled($storeId)
        ) {
            return false;
        }

        $paymentMethod = $quote->getPaymentMethod() ?: $quote->getPayment()->getMethod();

        if ($paymentMethod !== Cashondelivery::PAYMENT_METHOD_CASHONDELIVERY_CODE) {
            return false;
        }

        return $this->validateBasedOnShipping($quote) && $this->validateBaseOnPostalCode($quote);
    }

    /**
     * @param CartInterface $quote
     *
     * @return bool
     */
    public function validateBasedOnShipping(CartInterface $quote)
    {
        if (!$this->configProvider->isCashOnDeliveryEnabled($quote->getStoreId())) {
            return false;
        }

        if (!$this->configProvider->getAllowedShipping($quote->getStoreId())) {
            return true;
        }

        $specificMethod = $this->configProvider->getSpecificShipping($quote->getStoreId());

        if (!$specificMethod) {
            return true;
        }

        $specificMethod = explode(',', $specificMethod);

        return in_array($quote->getShippingAddress()->getShippingMethod(), $specificMethod);
    }

    /**
     * @param CartInterface $quote
     * @param string|null $zipCode
     *
     * @return bool
     */
    public function validateBaseOnPostalCode(CartInterface $quote = null, $zipCode = null)
    {
        $storeId = $quote ? $quote->getStoreId() : null;
        if (!$this->configProvider->isCodeVerificationEnabled($storeId)) {
            return true;
        }

        $allowedCodes = $this->prepareCodes($storeId);

        if (!$allowedCodes) {
            return true;
        }

        $verificationType = $this->configProvider->getVerificationType($storeId);

        if ($zipCode) {
            $postCode = $zipCode;
        } else {
            if ($verificationType === AbstractAddress::TYPE_BILLING) {
                /** @var \Magento\Quote\Model\Quote\Address $address */
                $address = $quote->getBillingAddress();
            } else {
                $address = $quote->getShippingAddress();
            }

            $postCode = $address->getPostcode();
        }

        return array_search($postCode, $allowedCodes, true) !== false;
    }

    /**
     * @param int|null $storeId
     * @return array|bool|string
     */
    private function prepareCodes($storeId)
    {
        $allowedCodes = $this->configProvider->getAllowedPostalCodes($storeId);

        if (!$allowedCodes) {
            return false;
        }

        $allowedCodes = explode(',', $allowedCodes);
        $range = [];
        $preparedCodes = [];

        foreach ($allowedCodes as $codeRange) {
            $codeRange = trim($codeRange);
            $preparedCodes[] = $codeRange;

            if (strpos($codeRange, '/') !== false && !preg_match('/[A-Za-z$_-]|[ ]/', $codeRange, $matches)) {
                $codeRange = explode('/', $codeRange);
                $range = range((int)$codeRange[0], (int)$codeRange[1]);

                foreach ($range as &$code) {
                    $preparedCodes[] = str_pad($code, strlen($codeRange[0]), "0", STR_PAD_LEFT);
                }
            }
        }

        return $preparedCodes;
    }
}
