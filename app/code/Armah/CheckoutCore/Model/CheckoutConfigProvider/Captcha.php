<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\CheckoutConfigProvider;

use Armah\CheckoutCore\Model\Config\Source\CustomerRegistration;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Captcha implements ConfigProviderInterface
{
    public const SCOPE_TYPE_STORES = 'stores';
    public const SCOPE_TYPE_WEBSITES = 'websites';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig(): array
    {
        return ['armahOscCaptcha' => [
            'isLoginCaptcha' => $this->isLoginCaptchaEnabled(),
            'isCreateAccountCaptcha' => $this->isCreateAccountCaptchaEnabled(),
            'isLoginReCaptcha' => $this->isLoginReCaptchaEnabled(),
            'isCreateAccountReCaptcha' => $this->isCreateAccountReCaptchaEnabled(),
        ] ];
    }

    private function isLoginCaptchaEnabled(): bool
    {
        return $this->scopeConfig->getValue('customer/captcha/enable', self::SCOPE_TYPE_WEBSITES)
            && in_array(
                'user_login',
                explode(
                    ',',
                    (string)$this->scopeConfig->getValue('customer/captcha/forms', self::SCOPE_TYPE_WEBSITES)
                ),
                true
            )
            && $this->scopeConfig->getValue('checkout/options/enable_guest_checkout_login', self::SCOPE_TYPE_STORES);
    }

    private function isCreateAccountCaptchaEnabled(): bool
    {
        return $this->scopeConfig->getValue('customer/captcha/enable', self::SCOPE_TYPE_WEBSITES)
            && in_array(
                'user_create',
                explode(
                    ',',
                    (string)$this->scopeConfig->getValue('customer/captcha/forms', self::SCOPE_TYPE_WEBSITES)
                ),
                true
            )
            && in_array(
                $this->scopeConfig->getValue(
                    'armah_checkout/additional_options/create_account',
                    self::SCOPE_TYPE_STORES
                ),
                [CustomerRegistration::OPTIONAL, CustomerRegistration::REQUIRED],
                true
            );
    }

    private function isLoginReCaptchaEnabled(): bool
    {
        return $this->scopeConfig->getValue('recaptcha_frontend/type_for/customer_login', self::SCOPE_TYPE_WEBSITES)
            && $this->scopeConfig->getValue('checkout/options/enable_guest_checkout_login', self::SCOPE_TYPE_STORES);
    }

    private function isCreateAccountReCaptchaEnabled(): bool
    {
        return $this->scopeConfig->getValue('recaptcha_frontend/type_for/customer_create', self::SCOPE_TYPE_WEBSITES)
            && in_array(
                $this->scopeConfig->getValue(
                    'armah_checkout/additional_options/create_account',
                    self::SCOPE_TYPE_STORES
                ),
                [CustomerRegistration::OPTIONAL, CustomerRegistration::REQUIRED],
                true
            );
    }
}
