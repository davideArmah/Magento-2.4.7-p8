define([
    'jquery',
    'Magento_Checkout/js/model/url-builder',
    'mage/storage',
    'Magento_Ui/js/modal/modal'
], function ($, urlBuilder, storage) {
    'use strict';

    $.widget('mage.arCodCheckAvailable', {
        options: {
            successMessage: $("[data-arcashdel-js='allowed-postal-code']"),
            errorMessage: $("[data-arcashdel-js='not-allowed-postal-code']"),
            postalCode: $('#postal_code'),
            submit: $("[data-arcashdel-js='arcashdel-check-status']")
        },

        _create: function () {
            this._super();
            this.options.submit.on('click', function () {
                var postalCode = this.options.postalCode.val();

                if (postalCode) {
                    storage.post(
                        urlBuilder.createUrl('/cash_on_delivery/checkAvailable/:postalCode', {postalCode: postalCode}),
                        JSON.stringify({}),
                        false
                    ).done(function (result) {
                        if (result) {
                            this.options.successMessage.show();
                            this.options.errorMessage.hide();
                        } else {
                            this.options.errorMessage.show();
                            this.options.successMessage.hide();
                        }
                    }.bind(this));
                }
            }.bind(this));
        }
    });

    return $.mage.arCodCheckAvailable;
});
