define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'underscore'
], function ($, storage, _) {
    'use strict';

    const cacheKey = 'armah-checkout-data',
        SINGLE_STEP_KEY = 'arorder_attributes_fields',

        /**
         * @param {Object} data
         */
        saveData = function (data) {
            storage.set(cacheKey, data);
        },

        /**
         * @return {*}
         */
        getData = function () {
            let data = storage.get(cacheKey)();

            if ($.isEmptyObject(data)) {
                data = {
                    'armahShippingAttributes': null,
                    'armahPaymentAttributes': null
                };
                saveData(data);
            }

            return data;
        };

    return {

        /**
         * @param {String} key
         * @param {*} data
         * @returns void
         */
        setCheckoutData: function (key, data) {
            let obj = getData();

            obj[key] = data;

            saveData(obj);
        },

        /**
         * @param {String} key
         * @returns {Object|null}
         */
        getCheckoutData: function (key) {
            let data = getData();

            if (key === SINGLE_STEP_KEY && _.isUndefined(data[key])) {
                return this._resolveSingleStep(data);
            }

            return data[key];
        },

        /**
         * Join attributes data from all steps into one.
         *
         * On PayPal review page all attributes displayed in single place/step.
         *
         * @param {Object} data
         * @returns {Object}
         * @private
         */
        _resolveSingleStep: function (data) {
            let result = _.filter(data, _.isObject);

            if (_.isEmpty(result)) {
                return {};
            }

            result = $.extend(true, {}, ...result);
            this.setCheckoutData(SINGLE_STEP_KEY, result);

            return result;
        }
    };
});
