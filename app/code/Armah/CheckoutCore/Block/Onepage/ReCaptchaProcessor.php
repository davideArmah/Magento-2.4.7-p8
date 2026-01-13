<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Onepage;

use Armah\Base\Model\Di\Wrapper;
use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutCore\Model\Config\Source\CustomerRegistration;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class ReCaptchaProcessor implements LayoutProcessorInterface
{
    private const CUSTOMER_CREATE_RECAPTCHA_KEY = 'customer_create';

    /**
     * @var LayoutWalkerFactory
     */
    private $walkerFactory;

    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * Use Wrapper for compatibility with m2.3.7
     * @var Wrapper
     */
    private $captchaUiConfigResolver;

    /**
     * Use Wrapper for compatibility with m2.3.7
     * @var Wrapper
     */
    private $isCaptchaEnabled;

    public function __construct(
        Config $checkoutConfig,
        LayoutWalkerFactory $walkerFactory,
        ?Wrapper $captchaUiConfigResolver = null,
        ?Wrapper $isCaptchaEnabled = null
    ) {
        $this->checkoutConfig = $checkoutConfig;
        $this->walkerFactory = $walkerFactory;
        $this->captchaUiConfigResolver = $captchaUiConfigResolver;
        $this->isCaptchaEnabled = $isCaptchaEnabled;
    }

    /**
     * Add reCaptcha for Create New Customer Account
     *
     * @param array $jsLayout
     */
    public function process($jsLayout): array
    {
        if (!$this->checkoutConfig->isEnabled()
            || !$this->isCaptchaEnabled->isCaptchaEnabledFor(self::CUSTOMER_CREATE_RECAPTCHA_KEY)
            || !in_array(
                $this->checkoutConfig->getAdditionalOptions('create_account'),
                [CustomerRegistration::OPTIONAL, CustomerRegistration::REQUIRED],
                true
            )

        ) {
            return $jsLayout;
        }

        $walker = $this->walkerFactory->create(['layoutArray' => $jsLayout]);

        $walker->setValue(
            '{SHIPPING_ADDRESS}.>>.customer-email.>>.recaptcha-customer-create',
            [
                'component' => 'Magento_ReCaptchaFrontendUi/js/reCaptcha',
                'displayArea' => 'additional-login-form-fields',
                'configSource' => 'checkoutConfig',
                'reCaptchaId' => 'recaptcha-checkout-inline-create-wrapper',
                'settings' => $this->captchaUiConfigResolver->get(self::CUSTOMER_CREATE_RECAPTCHA_KEY)
            ]
        );

        return $walker->getResult();
    }
}
