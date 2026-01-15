/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'Armah_CheckoutCore/js/action/save-additional-fields',
    'Magento_Checkout/js/checkout-data'
], function (Component, saveAction) {
    'use strict';

    return Component.extend({
        saveAllowed: false,

        initialize: function () {
            this._super();
            this.source.on('archeckout.additional:save', this.saveForm.bind(this));
        },

        saveForm: function () {
            saveAction();
        }
    });
});
