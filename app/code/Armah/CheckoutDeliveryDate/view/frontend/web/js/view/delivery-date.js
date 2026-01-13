/**
 * Delivery Date View
 */
define([
    'jquery',
    'underscore',
    'uiComponent',
    'Armah_CheckoutCore/js/view/utils',
    'Armah_CheckoutDeliveryDate/js/action/update-delivery',
    'Armah_CheckoutDeliveryDate/js/model/delivery',
    'Magento_Checkout/js/model/payment/additional-validators',
    'Armah_CheckoutCore/js/view/checkout/datepicker'
], function (
    $,
    _,
    Component,
    viewUtils,
    updateAction,
    deliveryService,
    paymentValidatorRegistry
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Armah_CheckoutDeliveryDate/delivery_date',
            listens: {
                'update': 'update'
            }
        },
        isLoading: deliveryService.isLoading,
        _requiredFieldSelector: '.archeckout-delivery-date .field._required :input:not(:button)',

        initialize: function () {
            this._super();

            var self = this,
                validator = {
                    validate: self.validate.bind(self)
                };

            paymentValidatorRegistry.registerValidator(validator);

            return this;
        },

        update: function () {
            var data;

            if (this.validate()) {
                data = this.source.get('archeckoutDelivery');

                updateAction(data);
            }
        },

        /**
         * @param {boolean} hideError
         * @returns {boolean}
         */
        validate: function (hideError = false) {
            let validationResult;

            this.source.set('params.invalid', false);
            this.source.trigger('archeckoutDelivery.data.validate');

            if (this.source.get('params.invalid')) {
                if (hideError) {
                    //set current value as initialValue
                    this.source.trigger('archeckoutDelivery.data.overload');
                    //set initialValue to value and reset errors
                    this.source.trigger('archeckoutDelivery.data.reset');
                }

                return false;
            }

            validationResult = true;

            this.elems().forEach(function (item) {
                if (item.validate().valid === false) {
                    validationResult = false;

                    if (hideError) {
                        item.error(false);
                    }

                    return false;
                }

                return true;
            });

            return validationResult;
        },

        getDeliveryDateName: function () {
            return viewUtils.getBlockTitle('delivery');
        }
    });
});
