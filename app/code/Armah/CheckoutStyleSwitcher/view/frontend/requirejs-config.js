/* jshint browser:true jquery:true */
var armah_mixin_enabled = !window.armah_checkout_disabled,
    config;

config = {
    config: {
        mixins: {
            'Magento_Paypal/js/view/payment/method-renderer/in-context/checkout-express': {
                'Armah_CheckoutStyleSwitcher/js/view/payment/checkout-express-mixin': armah_mixin_enabled
            }
        }
    }
};
