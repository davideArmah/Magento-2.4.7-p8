<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Quote;

use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutCore\Model\FieldsDefaultProvider;
use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentMethodInterface;
use Magento\Quote\Api\Data\TotalsInterface;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

/**
 * Initialize additional quote data to avoid extra requests on storefront.
 */
class CheckoutInitialization implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * @var FieldsDefaultProvider
     */
    private $defaultProvider;

    /**
     * @var ServiceOutputProcessor
     */
    private $outputProcessor;

    /**
     * @var CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var Shipping\AddressMethods
     */
    private $addressMethods;

    /**
     * @var PaymentMethodManagementInterface
     */
    private $paymentMethodList;

    /**
     * @var CartTotalRepositoryInterface
     */
    private $cartTotalsRepository;

    /**
     * @var PaymentMethodInterface[]
     */
    private $payment;

    public function __construct(
        Config $checkoutConfig,
        FieldsDefaultProvider $defaultProvider,
        ServiceOutputProcessor $outputProcessor,
        CartRepositoryInterface $quoteRepository,
        Shipping\AddressMethods $addressMethods,
        PaymentMethodManagementInterface $paymentMethodList,
        CartTotalRepositoryInterface $cartTotalsRepository
    ) {
        $this->checkoutConfig = $checkoutConfig;
        $this->defaultProvider = $defaultProvider;
        $this->outputProcessor = $outputProcessor;
        $this->quoteRepository = $quoteRepository;
        $this->addressMethods = $addressMethods;
        $this->paymentMethodList = $paymentMethodList;
        $this->cartTotalsRepository = $cartTotalsRepository;
    }

    /**
     * Get shipping
     *
     * @param Quote $quote
     *
     * @return array|object
     * @deprecated not used anymore. Shipping rates will be calculated on frontend with AJAX
     * @see https://amasty.atlassian.net/browse/PDT-15358
     */
    public function getShippingMethods($quote)
    {
        $methods = $this->addressMethods->getShippingMethods($this->getShippingAddress($quote));

        return $this->outputProcessor->convertValue(
            $methods,
            '\Magento\Quote\Api\Data\ShippingMethodInterface[]'
        );
    }

    /**
     * Resolve quote shipping address.
     *
     * @param Quote $quote
     *
     * @return Address
     */
    public function getShippingAddress($quote)
    {
        if ($quote->getCustomerId() && $shippingAddress = $this->getCustomerShippingAddress($quote)) {
            return $shippingAddress;
        }

        /** @var Address $shippingAddress */
        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress->getId() && $shippingAddress->getCountryId()) {
            return $shippingAddress;
        }

        $shippingAddress->addData($this->defaultProvider->getDefaultData());
        if (!$shippingAddress->getCountryId()) {
            $shippingAddress->setCountryId($this->checkoutConfig->getDefaultCountryId());
        }

        return $shippingAddress;
    }

    /**
     * Check quote shipping address
     * convert customer address into shipping if quote shipping is not selected.
     * false if customer doesn't have any address.
     *
     * @param Quote $quote
     *
     * @return Address|false
     */
    private function getCustomerShippingAddress($quote)
    {
        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress->getId() && $shippingAddress->getCustomerAddressId()) {
            return $shippingAddress;
        }

        $customerAddress = $this->getCustomerAddress($quote->getCustomer());

        if (!$customerAddress) {
            return false;
        }

        $addressByCustomer = $quote->getShippingAddressByCustomerAddressId($customerAddress->getId());
        if ($addressByCustomer) {
            $quote->setShippingAddress($addressByCustomer);

            return $addressByCustomer;
        }

        $shippingAddress->importCustomerAddressData($customerAddress);

        return $shippingAddress;
    }

    /**
     * Get default of first customer address.
     *
     * @param CustomerInterface $customer
     *
     * @return AddressInterface|false
     */
    private function getCustomerAddress($customer)
    {
        $customer->getDefaultShipping();
        $addresses = $customer->getAddresses();
        if (empty($addresses)) {
            return false;
        }

        foreach ($addresses as $customerAddress) {
            if ($customerAddress->isDefaultShipping()) {
                return $customerAddress;
            }
        }

        return reset($addresses);
    }

    /**
     * Set initial values: shipping address, shipping method, payment method.
     * For avoid extra request on frontend while loading.
     * Note: $quote can be without id (new entity). For better optimization, don't save quote early.
     *
     * @param CartInterface|Quote $quote
     * @deprecated usage removed because of unpredictable profit. In some cases, this only slows page loading
     * @see https://amasty.atlassian.net/browse/PDT-15358
     */
    public function initializeShipping(CartInterface $quote)
    {
        $shippingAddress = $this->getShippingAddress($quote);
        $this->addressMethods->processShippingAssignment($quote, $shippingAddress);

        if (!$shippingAddress->getPaymentMethod() && ($paymentMethod = $this->getPaymentMethod($quote))) {
            $payment = $quote->getPayment();
            $shippingAddress->setPaymentMethod($paymentMethod->getCode());
            $payment->setMethod($paymentMethod->getCode());
        }
    }

    public function getPaymentMethod(CartInterface $quote): ?MethodInterface
    {
        $activeMethods = $this->getPaymentMethods($quote);
        if (count($activeMethods) === 1) {
            return reset($activeMethods);
        }

        if ($defaultMethod = $this->checkoutConfig->getDefaultPaymentMethod()) {
            foreach ($activeMethods as $method) {
                if ($method->getCode() == $defaultMethod) {
                    return $method;
                }
            }
        }

        return null;
    }

    /**
     * @param CartInterface $quote
     *
     * @return array
     */
    public function getPaymentArray(CartInterface $quote): array
    {
        $methodsArray = $this->outputProcessor->convertValue(
            $this->getPaymentMethods($quote),
            PaymentMethodInterface::class . '[]'
        );

        return [
            PaymentDetailsInterface::PAYMENT_METHODS => $methodsArray,
            PaymentDetailsInterface::TOTALS => $this->getTotalsArray((int)$quote->getid())
        ];
    }

    /**
     * Save quote with initial data
     *
     * @param CartInterface $quote
     * @deprecated not used anymore. Quote save uses a lot of resources
     * @see https://amasty.atlassian.net/browse/PDT-15358
     */
    public function saveInitial(CartInterface $quote)
    {
        // On this stage, items are "null". Replace it with an empty array to avoid errors with foreach
        $quote->setItems([]);
        if ($quote->getExtensionAttributes()
            && ($shippingAssignments = $quote->getExtensionAttributes()->getShippingAssignments())
            && $shippingAssignments[0]->getItems() === null
        ) {
            $shippingAssignments[0]->setItems([]);
        }

        $this->quoteRepository->save($quote);
    }

    /**
     * Save initial shipping address
     *
     * Customer on One Step Checkout can select payment method before shipping method.
     * Payment Method selection can throw error if the shipping address doesn't have a selected country id
     */
    public function saveInitialShipping(CartInterface $quote): void
    {
        $shippingAddress = $this->getShippingAddress($quote);
        if (!$shippingAddress->getId() || !$shippingAddress->getOrigData('country_id')) {
            $shippingAddress->save();
        }
    }

    /**
     * @param CartInterface $quote
     *
     * @return MethodInterface[]
     */
    public function getPaymentMethods(CartInterface $quote): array
    {
        if (!isset($this->payment)) {
            $this->payment = $this->paymentMethodList->getList($quote->getId());
        }

        return $this->payment;
    }

    /**
     * @param int $quoteId
     *
     * @return array
     * @deprecated not used anymore
     * @see https://amasty.atlassian.net/browse/PDT-15358
     */
    public function getTotalsArray(int $quoteId): array
    {
        $totals = $this->cartTotalsRepository->get($quoteId);

        return $this->outputProcessor->convertValue($totals, TotalsInterface::class);
    }
}
