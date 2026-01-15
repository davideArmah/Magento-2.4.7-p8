<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Block\Onepage\LayoutProcessor;

use Armah\Checkout\Model\BillingAddress;
use Armah\Checkout\Model\Config as ConfigProvider;
use Armah\Checkout\Model\Config\Source\PhoneValidationOptions;
use Armah\CheckoutCore\Block\Onepage\LayoutWalker;
use Armah\CheckoutCore\Block\Onepage\LayoutWalkerFactory;
use Armah\CheckoutCore\Model\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class PhoneValidationProcessor implements LayoutProcessorInterface
{
    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * @var LayoutWalkerFactory
     */
    private $walkerFactory;

    /**
     * @var LayoutWalker
     */
    private $walker;

    /**
     * @var BillingAddress
     */
    private $billingAddress;

    public function __construct(
        Config $checkoutConfig,
        BillingAddress $billingAddress,
        LayoutWalkerFactory $walkerFactory
    ) {
        $this->checkoutConfig = $checkoutConfig;
        $this->billingAddress = $billingAddress;
        $this->walkerFactory = $walkerFactory;
    }

    /**
     * @param array $jsLayout
     *
     * @return array
     */
    public function process($jsLayout): array
    {
        $validationType = (int)$this->checkoutConfig->getAdditionalOptions(
            ConfigProvider::FIELD_PHONE_VALIDATION_TYPE
        );
        if (($validationType === PhoneValidationOptions::PHONE_VALIDATION_NONE)
            || (!$this->checkoutConfig->isEnabled())
        ) {
            return $jsLayout;
        }

        $this->walker = $this->walkerFactory->create(['layoutArray' => $jsLayout]);
        $billingAddressPath = $this->billingAddress->getBillingPath($this->walker);
        $minPhoneLength = (int)$this->checkoutConfig->getAdditionalOptions(ConfigProvider::FIELD_PHONE_MIN_LENGTH);
        $maxPhoneLength = (int)$this->checkoutConfig->getAdditionalOptions(ConfigProvider::FIELD_PHONE_MAX_LENGTH);

        $this->addPhoneValidation(
            '{SHIPPING_ADDRESS_FIELDSET}.>>.telephone.validation',
            $validationType,
            $minPhoneLength,
            $maxPhoneLength
        );

        foreach ($billingAddressPath as $path) {
            $this->addPhoneValidation(
                $path . '.telephone.validation',
                $validationType,
                $minPhoneLength,
                $maxPhoneLength
            );
        }

        return $this->walker->getResult();
    }

    private function addPhoneValidation(
        string $path,
        int $validationType,
        int $minPhoneLength,
        int $maxPhoneLength
    ): void {
        $validations = $this->walker->getValue($path) ?? [];
        foreach (array_keys($validations) as $key) {
            if ($key !== 'required-entry') {
                unset($validations[$key]);
            }
        }
        $validations['min_text_length'] = $minPhoneLength;
        $validations['max_text_length'] = $maxPhoneLength;

        if ($validationType === PhoneValidationOptions::PHONE_VALIDATION_NUMERIC) {
            $validations['validate-digits'] = true;
        } else {
            $validations['validate-numbers-and-spec-characters'] = true;
        }

        $this->walker->setValue($path, $validations);
    }
}
