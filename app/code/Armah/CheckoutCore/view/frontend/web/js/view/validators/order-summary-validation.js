define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/additional-validators',
    'Armah_CheckoutCore/js/model/payment-validators/order-summary-validator'
], function (Component, additionalValidators, orderSummaryValidator) {
    'use strict';

    additionalValidators.registerValidator(orderSummaryValidator);

    return Component.extend({});
});
