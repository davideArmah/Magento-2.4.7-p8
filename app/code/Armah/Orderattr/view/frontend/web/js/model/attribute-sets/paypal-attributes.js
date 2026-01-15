define([
    'Magento_Checkout/js/model/quote'
], function (quote) {
    'use strict';

    var attributesTypes = ['arorder_attributes_fields'],
        formCode = 'armah_checkout';

    if (quote.isVirtual()) {
        formCode = 'armah_checkout_virtual';
    }

    return {
        'attributeTypes': attributesTypes,
        'formCode': formCode
    }
});
