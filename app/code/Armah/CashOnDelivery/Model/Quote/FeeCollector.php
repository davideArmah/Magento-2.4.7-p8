<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Quote;

use Armah\CashOnDelivery\Api\PaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Model\Config\Source\FixedCalculateBasedOn;
use Armah\CashOnDelivery\Model\Config\Source\PaymentFeeTypes;
use Armah\CashOnDelivery\Model\Config\Source\PercentCalculateBasedOn;
use Armah\CashOnDelivery\Model\ConfigProvider;
use Armah\CashOnDelivery\Model\PaymentFeeFactory;
use Armah\CashOnDelivery\Model\PaymentValidator;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Tax\Model\Calculation;
use Magento\Tax\Model\Config;
use Magento\Tax\Model\Sales\Total\Quote\CommonTaxCollector;
use Psr\Log\LoggerInterface;

class FeeCollector extends AbstractTotal
{
    public const HUNDRED_PERCENT = 100;

    /**
     * @var PaymentValidator
     */
    private $paymentValidator;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var PaymentFeeRepositoryInterface
     */
    private $paymentFeeRepository;

    /**
     * @var PaymentFeeFactory
     */
    private $paymentFeeFactory;

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Calculation
     */
    private $calculationTool;

    /**
     * @var array
     */
    private $paymentFeeData = [
        'amount' => 0,
        'base_amount' => 0,
        'tax_amount' => 0,
        'base_tax_amount' => 0
    ];

    public function __construct(
        PaymentValidator $paymentValidator,
        ConfigProvider $configProvider,
        PaymentFeeRepositoryInterface $paymentFeeRepository,
        PaymentFeeFactory $paymentFeeFactory,
        PriceCurrencyInterface $priceCurrency,
        LoggerInterface $logger,
        Calculation $calculationTool
    ) {
        $this->paymentValidator = $paymentValidator;
        $this->configProvider = $configProvider;
        $this->paymentFeeRepository = $paymentFeeRepository;
        $this->paymentFeeFactory = $paymentFeeFactory;
        $this->priceCurrency = $priceCurrency;
        $this->logger = $logger;
        $this->calculationTool = $calculationTool;
    }

    /**
     * @inheritdoc
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        try {
            if ($total->getBaseSubtotal() || $total->getBaseShippingAmount()) {
                $this->paymentFeeData['quote_id'] = $quote->getId();

                $total->setBaseTotalAmount($this->getCode(), 0);
                $total->setTotalAmount($this->getCode(), 0);

                try {
                    /** @var \Armah\CashOnDelivery\Model\PaymentFee $paymentFee */
                    $paymentFee = $this->paymentFeeRepository->getByQuoteId($quote->getId());
                } catch (NoSuchEntityException $exception) {
                    $paymentFee = $this->paymentFeeFactory->create();
                }

                if ($this->paymentValidator->validatePaymentFee($quote)) {
                    $address = $shippingAssignment->getShipping()->getAddress();
                    $this->calculateFee($quote, $total, $address);

                    $total->setBaseTotalAmount($this->getCode(), $this->paymentFeeData['base_amount']);
                    $total->setTotalAmount($this->getCode(), $this->paymentFeeData['amount']);
                }

                if ($paymentFee->getAmount() != $this->paymentFeeData['amount']) {
                    $paymentFee->addData($this->paymentFeeData);
                    $this->paymentFeeRepository->save($paymentFee);
                }
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return $this;
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param Quote $quote
     * @param Total $total
     *
     * @return array
     * @codingStandardsIgnoreStart
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(Quote $quote, Total $total)
    {
        try {
            /** @var \Armah\CashOnDelivery\Model\PaymentFee $paymentFee */
            $paymentFee = $this->paymentFeeRepository->getByQuoteId($quote->getId());
        } catch (NoSuchEntityException $exception) {
            return null;
        }

        if ($paymentFee && $paymentFee->getAmount()) {
            $amountExclTax = $amountInclTax = $paymentFee->getAmount();
            if ($paymentFee->getTaxAmount()) {
                $amountInclTax += $paymentFee->getTaxAmount();
            }

            return [
                'code' => $this->getCode(),
                'title' => __($this->getLabel()),
                'value' => $this->configProvider->getDisplayFeeAtCart() == Config::DISPLAY_TYPE_EXCLUDING_TAX
                    ? $amountExclTax
                    : $amountInclTax,
                'value_excl_tax' => $amountExclTax,
                'value_incl_tax' => $amountInclTax
            ];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->configProvider->getPaymentFeeLabel();
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @param AddressInterface $address
     */
    private function calculateFee(Quote $quote, Total $total, $address): void
    {
        $storeId = (int)$quote->getStoreId();
        $fee = $this->configProvider->getPaymentFee($storeId);

        $paymentFeeType = $this->configProvider->getPaymentFeeType($storeId);
        if ($paymentFeeType == PaymentFeeTypes::PERCENT) {
            $fee = $this->calculatePercentFee($total, $fee, $storeId);
        } elseif ($paymentFeeType == PaymentFeeTypes::FIXED_AMOUNT) {
            $fee = $this->calculateFixedFee($quote, $fee, $address, $storeId);
        }

        $this->paymentFeeData['base_amount'] = $fee;
        $this->paymentFeeData['amount'] = $this->getStoreCurrencyAmount($this->paymentFeeData['base_amount'], $storeId);
    }

    /**
     * @param Total $total
     * @param float|int $fee
     * @param int $storeId
     * @return float|int
     */
    private function calculatePercentFee(Total $total, $fee, $storeId)
    {
        $calculateBasedOn = $this->configProvider->getPercentCalculateBasedOn($storeId);
        if ($calculateBasedOn == PercentCalculateBasedOn::EXCLUDING_TAX) {
            $fee = $total->getBaseSubtotal() / self::HUNDRED_PERCENT * $fee;
        } elseif ($calculateBasedOn == PercentCalculateBasedOn::INCLUDING_TAX) {
            $fee = $total->getBaseSubtotalInclTax() / self::HUNDRED_PERCENT * $fee;
        }

        return $fee;
    }

    /**
     * @param Quote $quote
     * @param float|int $fee
     * @param AddressInterface $address
     * @param int $storeId
     * @return float|int
     */
    private function calculateFixedFee(Quote $quote, $fee, $address, $storeId)
    {
        if ($taxClassId = $this->configProvider->getTaxClassForFixedFee($storeId)) {
            $calculateBasedOn = $this->configProvider->getFixedCalculateBasedOn($storeId);
            $rate = $this->calculationTool->getRate($this->getTaxRateRequest($quote, $taxClassId));
            if ($calculateBasedOn == FixedCalculateBasedOn::EXCLUDING_TAX) {
                $taxAmount = $this->calculationTool->calcTaxAmount($fee, $rate, false, false);
                $this->paymentFeeData['base_tax_amount'] = $taxAmount;
                $this->addFeeTax($address, $fee, $taxClassId, $storeId);
            } else {
                $taxAmount = $this->calculationTool->calcTaxAmount($fee, $rate, true, false);
                $this->paymentFeeData['base_tax_amount'] = $taxAmount;
                $baseFee = $fee;
                $fee -= $taxAmount;
                $this->addFeeTax($address, $baseFee, $taxClassId, $storeId, true);
            }
            $this->paymentFeeData['tax_amount']
                = $this->getStoreCurrencyAmount($this->paymentFeeData['base_tax_amount'], $storeId);
        }

        return $fee;
    }

    /**
     * @param AddressInterface $address
     * @param float|int $baseFeeAmount
     * @param int $taxClassId
     * @param int $storeId
     * @param bool $priceIncludeTax
     */
    private function addFeeTax($address, $baseFeeAmount, $taxClassId, $storeId, $priceIncludeTax = false)
    {
        $associatedTaxables = $address->getAssociatedTaxables();
        if (!$associatedTaxables) {
            $associatedTaxables = [];
        }

        $feeAmount = $this->getStoreCurrencyAmount($baseFeeAmount, $storeId);

        $associatedTaxables[] = [
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_TYPE => 'fee',
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_CODE => $this->getCode(),
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_UNIT_PRICE => $feeAmount,
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_BASE_UNIT_PRICE => $baseFeeAmount,
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_QUANTITY => 1,
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_TAX_CLASS_ID => $taxClassId,
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_PRICE_INCLUDES_TAX => $priceIncludeTax,
            CommonTaxCollector::KEY_ASSOCIATED_TAXABLE_ASSOCIATION_ITEM_CODE
            => CommonTaxCollector::ASSOCIATION_ITEM_CODE_FOR_QUOTE,
        ];

        $address->setAssociatedTaxables($associatedTaxables);
    }

    /**
     * @param float $amount
     * @param int $storeId
     * @return float
     */
    private function getStoreCurrencyAmount($amount, $storeId)
    {
        return $this->priceCurrency->convert($amount, $storeId);
    }

    /**
     * @param Quote $quote
     * @param int $taxClassId
     * @return DataObject
     */
    private function getTaxRateRequest(Quote $quote, $taxClassId)
    {
        return $this->calculationTool->getRateRequest(
            $quote->getShippingAddress(),
            $quote->getBillingAddress(),
            $quote->getCustomerTaxClassId(),
            $quote->getStore(),
            $quote->getCustomerId()
        )->setProductClassId($taxClassId);
    }
}
