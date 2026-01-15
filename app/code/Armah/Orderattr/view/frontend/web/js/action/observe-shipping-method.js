define([
    'ko',
    'underscore',
    'mageUtils',
    'uiClass',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/model/quote'
], function (ko, _, utils, Class, shippingService, quote) {
    'use strict';

    return Class.extend({

        element: null,

        initialize: function (element) {
            this.element = element;
        },

        observeShippingMethods: function () {
            if (this.getShippingMethods().length) {
                quote.shippingMethod.subscribe(this.toggleVisibilityForRate, this);
                /* hide element if no shipping method is selected*/
                this.toggleVisibilityForRate();
            }

            return this;
        },

        toggleVisibility: function(rates) {
            _.some(rates, function(rate) {
                return this.toggleVisibilityForRate(rate);
            }, this);
        },

        toggleVisibilityForRate: function (rate) {
            var shippingMethodCode = this.getShippingMethodCode(rate);
            var visible = false;

            if (shippingMethodCode) {
                visible = _.contains(this.getShippingMethods(), shippingMethodCode);
                this.element.arHidedByRate(!visible);
            } else {
                this.element.arHidedByRate(true);
            }

            return visible;
        },

        getShippingMethods: function() {
            return this.element.shipping_methods;
        },

        getShippingMethodCode: function (rate) {
            if (!quote.shippingMethod()) {
                return false;
            }

            if (!rate) {
                rate = quote.shippingMethod();
            }

            if (rate.carrier_code && rate.method_code) {
                return rate.carrier_code + '_' + rate.method_code;
            }

            return false;
        }
    });
});
