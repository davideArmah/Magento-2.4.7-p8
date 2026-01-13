define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals',
    'Armah_CashOnDelivery/js/model/tax-utils'
], function (Component, quote, priceUtils, totals, taxUtils) {
    "use strict";

    return Component.extend({
        taxUtils: taxUtils,

        /**
         * @returns {Boolean}
         */
        isDisplayed: function () {
            return !!totals.getSegment('armah_cash_on_delivery_fee');
        },

        /**
         * @returns {String}
         */
        getPaymentFeeLabel: function () {
            return totals.getSegment('armah_cash_on_delivery_fee').title;
        },

        /**
         * Get formatted price
         *
         * @param {String} type
         * @return {String}
         */
        getValue: function (type) {
            var price = this.getDetailsSegment()[type];

            return this.getFormattedPrice(price);
        },

        /**
         * @returns {Object}
         */
        getDetailsSegment: function () {
            var segmentExtraFee = totals.getSegment('armah_cash_on_delivery_fee');

            return segmentExtraFee['extension_attributes']['tax_armah_cod_fee_details'];
        },
    });
});
