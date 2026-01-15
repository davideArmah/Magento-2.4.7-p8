define([
    'jquery'
], function ($) {
    'use strict';

    var checkoutConfig = window.checkoutConfig,

        // Excluding price with tax type
        EXCLUDING_PRICE_TYPE = 1,

        // Including price with tax type
        INCLUDING_PRICE_TYPE = 2,

        // Including and excluding price with tax type
        BOTH_PRICE_TYPE = 3,

        // Cash on delivery fee type
        FEE_TYPE_FIXED = 0

    return {
        paymentFeeType: checkoutConfig.armah.cashOnDelivery.paymentFeeType,
        displayPriceMode: checkoutConfig.armah.cashOnDelivery.displayPriceMode,

        /**
         * @return {Boolean}
         */
        isBothPricesDisplayed: function () {
            return this.displayPriceMode === BOTH_PRICE_TYPE;
        },

        /**
         * @return {Boolean}
         */
        isIncludingTaxDisplayed: function () {
            return this.displayPriceMode === INCLUDING_PRICE_TYPE;
        },

        /**
         * @return {Boolean}
         */
        isExcludingDisplayed: function () {
            return this.displayPriceMode === EXCLUDING_PRICE_TYPE;
        },

        /**
         * @return {Boolean}
         */
        isFeeTypeFixed: function () {
            return this.paymentFeeType === FEE_TYPE_FIXED;
        }
    };
});
