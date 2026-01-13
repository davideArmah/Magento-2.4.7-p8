# magento2-stripeintegration-payments
Hyvä Themes Compatibility module for StripeIntegration_Payments

## Notes

We’ve built a Hyvä Compat module that enables Instant/Express Payments via Stripe in your Hyvä theme. This will show on the Product Page, Cart and Minicart if it's enabled in them places.

This is something that works alongside your Hyvä frontend theme and will not affect the official Stripe module that runs on the standard out the box Checkout. The official Stripe Module will need to be installed and configured first before moving onto installing the Hyvä Compat Stripe Module. This is to help spot where any potential issues may be.

You should be able to successfully checkout using Stripe (Stripe in test mode is fine too) before continuing with the Hyvä Compat installation.

This module will require jQuery (already included), a future release should remove this entirely. Refactoring is already work in progress for this.

## Installation

### Via packagist.com

Hyvä Compatibility modules that are tagged as stable can be installed using composer via packagist.com:

1. Install via composer
    ```
    composer require hyva-themes/magento2-stripeintegration-payments
    ```
2. Enable module
    ```
    bin/magento setup:upgrade
    ```


### Via gitlab

For development of or to contribute to a compatibility module, it needs to be installed using composer via gitlab.  
This installation method is not suited for deployments, because gitlab requires SSH key authorization.

1. Install via composer
   If this is the first time a compatibility module is installed via gitlab, the compat-module-fallback repository has to be
   added as a composer repository. This step is only required once.
    ```
    composer config repositories.hyva-themes/magento2-compat-module-fallback git git@gitlab.hyva.io:hyva-themes/magento2-compat-module-fallback.git
    ```

   When the compat-module-fallback repo is configured, the compatibility module itself can be installed with composer:
    ```
    composer config repositories.hyva-themes/magento2-stripeintegration-payments git git@gitlab.hyva.io:hyva-themes/hyva-compat/magento2-stripeintegration-payments.git
    composer require hyva-themes/magento2-stripeintegration-payments:dev-main
    ```
2. Enable module
    ```
    bin/magento setup:upgrade
    ```
3. Ensure stripe configuration is already configured from the core StripeIntegration_Payments module.

## Usage
When installed the Express Payment options that are within the official Stripe module, in the admin panel - will now be used to display Express Payments by Stripe if enabled.

Out the box there are a few Express Payments that can be used and will be shown depending on if your current browser supports this.
- Apple Pay
- Google Pay
- Perhaps Stripe Link (usually a fallback payment method by Stripe now)

## Troubleshooting
Apple Pay not showing:

To determine whether your device and browser is supported refer to these documents: https://stripe.com/docs/stripe-js/elements/payment-request-button

If it shows Apple Pay on the above link, and you’re Stripe credentials are setup correctly from the Official Stripe module (in the admin) then it should also show Apple Pay on the Hyvä theme now too.
