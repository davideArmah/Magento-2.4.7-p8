define([
    'Magento_Checkout/js/model/quote'
], function (quote) {
    'use strict';

    var attributesTypes = [
            'armahShippingAttributes',
            'armahShippingBeforeAttributes',
            'armahPaymentAttributes',
            'armahSummaryAttributes',
            'armahShippingMethodAttributes',
            'armahShippingMethodAfterAttributes',
            'before-place-order.armahPaymentMethodAttributes'
        ],
        formCode = 'armah_checkout';

    if (quote.isVirtual()) {
        attributesTypes = [
            'armahPaymentAttributes',
            'before-place-order.armahPaymentMethodAttributes',
            'armahSummaryAttributes'
        ];
        formCode = 'armah_checkout_virtual';
    }

    return {
        'attributeTypes': attributesTypes,
        'formCode': formCode
    }
});
