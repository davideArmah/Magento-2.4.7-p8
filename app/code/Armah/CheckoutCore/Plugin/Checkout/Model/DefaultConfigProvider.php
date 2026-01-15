<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Checkout\Model;

use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutCore\Model\FieldsDefaultProvider;
use Armah\CheckoutCore\Model\ModuleEnable;
use Armah\CheckoutCore\Model\Quote\CheckoutInitialization;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\View\LayoutInterface;

class DefaultConfigProvider
{
    public const IS_CHECKOUT_ITEMS_EDITABLE = 'isCheckoutItemsEditable';

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var FieldsDefaultProvider
     */
    private $fieldsDefaultProvider;

    /**
     * @var CheckoutInitialization
     */
    private $checkoutInitialization;

    /**
     * @var \Magento\Customer\Api\AddressMetadataInterface
     */
    private $addressMetadata;

    /**
     * @var Session
     */
    private $customerSession;

    public function __construct(
        CheckoutSession $checkoutSession,
        LayoutInterface $layout,
        ModuleEnable $moduleEnable,
        Config $config,
        FieldsDefaultProvider $fieldsDefaultProvider,
        CheckoutInitialization $checkoutInitialization,
        \Magento\Customer\Api\AddressMetadataInterface $addressMetadata,
        Session $customerSession
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->layout = $layout;
        $this->moduleEnable = $moduleEnable;
        $this->config = $config;
        $this->fieldsDefaultProvider = $fieldsDefaultProvider;
        $this->checkoutInitialization = $checkoutInitialization;
        $this->addressMetadata = $addressMetadata;
        $this->customerSession = $customerSession;
    }

    /**
     * Modify checkout config data.
     *
     * @param \Magento\Checkout\Model\DefaultConfigProvider $subject
     * @param array $config
     *
     * @return array
     */
    public function afterGetConfig(\Magento\Checkout\Model\DefaultConfigProvider $subject, $config)
    {
        if (!in_array('armah_checkout', $this->layout->getUpdate()->getHandles(), true)) {
            return $config;
        }

        $quote = $this->checkoutSession->getQuote();
        if (!$this->customerSession->isLoggedIn() && $quote->getCustomerId() && $quote->getCustomerIsGuest()) {
            $quote->setCustomerIsGuest(false);
        }

        $defaultData = $this->fieldsDefaultProvider->getDefaultData();
        if ($defaultData) {
            foreach ($defaultData as $field => $value) {
                $config['amdefault'][$field] = $value;
            }
        }

        $isCheckoutItemsEditable = $this->config->isCheckoutItemsEditable();
        $config[self::IS_CHECKOUT_ITEMS_EDITABLE] = $isCheckoutItemsEditable;

        if ($this->moduleEnable->isPostNlEnable()) {
            $config['quoteData']['posnt_nl_enable'] = true;
        }

        $config['quoteData']['additional_options']['create_account'] =
            $this->config->getAdditionalOptions('create_account');

        if (!$quote->isVirtual()) {
            $this->checkoutInitialization->saveInitialShipping($quote);
        }
        $config['quoteData']['initPayment'] = $this->checkoutInitialization->getPaymentArray($quote);

        if (!isset($config['shippingAddressFromData'])) {
            $shippingAddress = $quote->getShippingAddress();
            if ($shippingAddress->getCustomerAddressId()) {
                $config['selectedShippingAddressId'] = $shippingAddress->getCustomerAddressId();
            } else {
                $config['shippingAddressFromData'] = $this->getAddressFromData($shippingAddress);
            }
        } elseif (isset($config['shippingAddressFromData']['postcode'])
            && $config['shippingAddressFromData']['postcode'] === '-'
        ) {
            unset($config['shippingAddressFromData']['postcode']);
        }

        return $config;
    }

    /**
     * Create address data appropriate to fill checkout address form.
     *
     * @param \Magento\Quote\Api\Data\AddressInterface $address
     * @return array
     */
    private function getAddressFromData(\Magento\Quote\Api\Data\AddressInterface $address)
    {
        $addressData = [];
        $attributesMetadata = $this->addressMetadata->getAllAttributesMetadata();
        foreach ($attributesMetadata as $attributeMetadata) {
            if (!$attributeMetadata->isVisible()) {
                continue;
            }
            $attributeCode = $attributeMetadata->getAttributeCode();
            $attributeData = $address->getData($attributeCode);
            if ($attributeData && $attributeData != '-') {
                if ($attributeMetadata->getFrontendInput() === \Magento\Ui\Component\Form\Element\Multiline::NAME) {
                    $attributeData = \is_array($attributeData) ? $attributeData : explode("\n", $attributeData);
                    $attributeData = (object)$attributeData;
                }
                if ($attributeMetadata->isUserDefined()) {
                    $addressData[CustomAttributesDataInterface::CUSTOM_ATTRIBUTES][$attributeCode] = $attributeData;
                    continue;
                }
                $addressData[$attributeCode] = $attributeData;
            }
        }

        return $addressData;
    }
}
