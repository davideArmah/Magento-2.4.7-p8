define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Armah_Orderattr/js/model/attribute-sets/paypal-attributes',
    'Armah_Orderattr/js/model/validate-and-save'
], function ($, quote, attributesForm, validateAndSave) {
    'use strict';

    var paypalExpressMixin = {
        validatePassed: false,

        _submitOrder: function () {
            if (this.validatePassed) {
                return this._super();
            } else {
                validateAndSave(attributesForm).done(() => {
                    this.validatePassed = true;
                    return this._submitOrder();
                });
            }
        },

        /**
         * Update quote shipping method for correct update attribute fields.
         *
         * @private
         */
        _updateOrderSubmit: function (shouldDisable, fn) {
            let shippingMethod = $(this.options.shippingSubmitFormSelector)
                .find(this.options.shippingSelector).val();

            this._super(shouldDisable, fn);

            if (shippingMethod) {
                shippingMethod = shippingMethod.split('_');

                quote.shippingMethod({
                    'carrier_code': shippingMethod[0],
                    'method_code': shippingMethod[1]
                });
            }
        }
    };

    return function (paypalExpressWidget) {
        $.widget('mage.orderReview', paypalExpressWidget, paypalExpressMixin);
        return $.mage.orderReview;
    };
});
