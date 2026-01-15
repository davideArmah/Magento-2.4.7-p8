define([
    'jquery',
    'mage/utils/wrapper',
    'Armah_Orderattr/js/model/attribute-sets/shipping-attributes',
    'Armah_Orderattr/js/model/validate-and-save'
], function ($, wrapper, attributesForm, validateAndSave) {
    'use strict';

    if (typeof window.checkoutConfig.arOrderAttribute.sendOnShipping !== "undefined"
        && !window.checkoutConfig.arOrderAttribute.sendOnShipping) {
        return function (setShippingInformationAction) {
            return setShippingInformationAction;
        }
    } else {
        return function (setShippingInformationAction) {
            return wrapper.wrap(setShippingInformationAction, function (originalAction) {
                var result = $.Deferred();

                validateAndSave(attributesForm).done(
                    function () {
                        $.when(
                            originalAction()
                        ).fail(
                            function () {
                                result.reject.apply(this, arguments);
                            }
                        ).done(
                            function () {
                                result.resolve.apply(this, arguments);
                            }
                        );
                    }
                ).fail(
                    function () {
                        result.reject();
                    }
                );

                return result.promise();
            });
        };
    }
});
