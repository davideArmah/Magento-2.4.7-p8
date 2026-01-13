/* eslint-disable camelcase */
var armah_mixin_enabled = !window.armah_checkout_disabled,
    config;

config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/billing-address': {
                'Armah_Checkout/js/view/billing-address-mixin': armah_mixin_enabled
            },
            'Magento_Checkout/js/view/shipping': {
                'Armah_Checkout/js/view/shipping-mixin': armah_mixin_enabled
            }
        }
    },
    shim: {
        'Armah_CheckoutCore/js/view/onepage': [
            'Armah_Checkout/js/validation/phone-validation'
        ]
    }
};
