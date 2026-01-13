var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Armah_Orderattr/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Armah_Orderattr/js/action/place-order-mixin': true
            },
            'Amazon_Payment/js/action/place-order': {
                'Armah_Orderattr/js/action/place-order-mixin': true
            },
            'Magento_Paypal/js/action/set-payment-method': {
                'Armah_Orderattr/js/action/set-payment-method-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'Armah_Orderattr/js/action/set-payment-information-mixin': true
            },
            'Magento_Paypal/js/order-review': {
                'Armah_Orderattr/js/action/paypal-express-submit-mixin': true
            }
        }
    }
};
