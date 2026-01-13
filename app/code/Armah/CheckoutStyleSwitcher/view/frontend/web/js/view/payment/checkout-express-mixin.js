define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Armah_CheckoutStyleSwitcher/js/model/aralert',
    'mage/translate'
], function ($, quote, alert) {
    'use strict';

    return function (Component) {
        return Component.extend({
            /**
             * Execute additional logic on Paypal button click
             */
            onClick: function () {
                this._super();

                if (!quote.shippingMethod() && !quote.isVirtual()) {
                    alert({ content: $.mage.__('No shipping method selected') });
                }
            }
        });
    };
});
