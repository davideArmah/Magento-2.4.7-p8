/* jshint browser:true jquery:true */
var armah_mixin_enabled = !window.armah_checkout_disabled,
    config;

config = {
    'map': { '*': {} },
    config: {
        mixins: {
            'Magento_Checkout/js/model/new-customer-address': {
                'Armah_CheckoutCore/js/model/new-customer-address-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/payment/list': {
                'Armah_CheckoutCore/js/view/payment/list': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/summary/abstract-total': {
                'Armah_CheckoutCore/js/view/summary/abstract-total': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/step-navigator': {
                'Armah_CheckoutCore/js/model/step-navigator-mixin': armah_mixin_enabled
            },
            'Magento_Paypal/js/action/set-payment-method': {
                'Armah_CheckoutCore/js/action/set-payment-method-mixin': armah_mixin_enabled
            },
            'Magento_CheckoutAgreements/js/model/agreements-assigner': {
                'Armah_CheckoutCore/js/model/agreements-assigner-mixin': armah_mixin_enabled
            },
            'Magento_CheckoutAgreements/js/view/checkout-agreements': {
                'Armah_CheckoutCore/js/view/checkout-agreements-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/summary': {
                'Armah_CheckoutCore/js/view/summary-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/shipping': {
                'Armah_CheckoutCore/js/view/shipping-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/summary/cart-items': {
                'Armah_CheckoutCore/js/view/summary/cart-items-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/payment/additional-validators': {
                'Armah_CheckoutCore/js/model/payment-validators/additional-validators-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/customer-email-validator': {
                'Armah_CheckoutCore/js/model/customer-email-validator-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Armah_CheckoutCore/js/model/checkout-data-resolver-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/shipping-rates-validator': {
                'Armah_CheckoutCore/js/model/shipping-rates-validator-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'Armah_CheckoutCore/js/action/set-shipping-information-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/full-screen-loader': {
                'Armah_CheckoutCore/js/model/full-screen-loader-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/shipping-rate-processor/new-address': {
                'Armah_CheckoutCore/js/model/default-shipping-rate-processor-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/payment': {
                'Armah_CheckoutCore/js/view/payment-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/payment-service': {
                'Armah_CheckoutCore/js/model/payment-service-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/address-converter': {
                'Armah_CheckoutCore/js/model/address-converter-mixin': armah_mixin_enabled
            },
            'Magento_Paypal/js/view/payment/method-renderer/in-context/checkout-express': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/in-context/checkout-express-mixin':
                    armah_mixin_enabled
            },

            // in Magento 2.4 module Magento_Braintree renamed to Paypal_Braintree
            'Magento_Braintree/js/view/payment/method-renderer/paypal': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/braintree/paypal-mixin':
                    armah_mixin_enabled
            },
            'PayPal_Braintree/js/view/payment/method-renderer/paypal': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/braintree/paypal-mixin':
                    armah_mixin_enabled
            },
            'Magento_Braintree/js/view/payment/method-renderer/cc-form': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/braintree/cc-form-mixin': armah_mixin_enabled
            },
            'PayPal_Braintree/js/view/payment/method-renderer/cc-form': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/braintree/cc-form-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/billing-address': {
                'Armah_CheckoutCore/js/view/billing-address-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/payment/default': {
                'Armah_CheckoutCore/js/view/payment/method-renderer/default-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/shipping-rate-registry': {
                'Armah_CheckoutCore/js/model/shipping-rate-registry-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/shipping-address/address-renderer/default': {
                'Armah_CheckoutCore/js/view/shipping-address/address-renderer/default-mixin': armah_mixin_enabled
            },
            'Armah_Gdpr/js/model/consents-assigner': {
                'Armah_CheckoutCore/js/model/consents-assigner-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/action/select-payment-method': {
                // Disable hardcoded save payment information
                // @see Armah_CheckoutCore/js/model/payment/salesrule-observer
                'Magento_SalesRule/js/action/select-payment-method-mixin': !armah_mixin_enabled
            },
            'Magento_Checkout/js/action/select-shipping-address': {
                'Armah_CheckoutCore/js/action/select-shipping-address-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/billing-address-postcode-validator': {
                'Armah_CheckoutCore/js/model/billing-address-postcode-validator-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/model/quote': {
                'Armah_CheckoutCore/js/model/quote-mixin': armah_mixin_enabled
            }
        }
    }
};

if (armah_mixin_enabled) {
    config.map['*'] = {
        checkoutCollapsibleSteps: 'Armah_CheckoutCore/js/view/checkout/design/collapsible-steps',
        arCheckoutCollapsible: 'Armah_CheckoutCore/js/checkout-collapsible',
        summaryWidget: 'Armah_CheckoutCore/js/view/summary/summary-widget',
        stickyWidget: 'Armah_CheckoutCore/js/view/summary/sticky-widget',
        'Magento_Checkout/template/payment-methods/list.html': 'Armah_CheckoutCore/template/payment-methods/list.html',
        'Magento_Checkout/template/billing-address/details.html':
            'Armah_CheckoutCore/template/onepage/billing-address/details.html',
        'Magento_Checkout/js/action/get-totals': 'Armah_CheckoutCore/js/action/get-totals',
        'Magento_Checkout/js/model/shipping-rate-service': 'Armah_CheckoutCore/js/model/shipping-rate-service-override',
        'Magento_Checkout/js/action/recollect-shipping-rates': 'Armah_CheckoutCore/js/action/recollect-shipping-rates',
        'Magento_InventoryInStorePickupFrontend/js/model/quote-ext': 'Armah_CheckoutCore/js/model/quote-ext-override'
    };
}
