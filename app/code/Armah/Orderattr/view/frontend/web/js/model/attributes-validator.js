define([
    'Armah_Orderattr/js/action/armah-validate-form',
    'Armah_Orderattr/js/model/attribute-sets/payment-attributes'
], function (validateForm, formData) {
    'use strict';

    return {
        /**
         * Validate checkout agreements
         *
         * @param {bool|undefined} hideError
         *
         * @returns {boolean}
         */
        validate: function(hideError = false) {
            window.orderAttributesPreSend = validateForm(formData.attributeTypes, hideError);
            return window.orderAttributesPreSend;
        }
    }
});
