define([
    'uiRegistry',
    'underscore'
], function (registry, _) {
    'use strict';

    function getCustomScope(attributeType) {
        if (attributeType.indexOf('.') !== -1) {
            return attributeType.substr(attributeType.indexOf('.') + 1);
        }

        return attributeType;
    }

    return function (attributesTypes, hideError = false) {
        let armahCheckoutProvider = registry.get('armahCheckoutProvider'),
            focused = false,
            result = {};

        armahCheckoutProvider.set('params.invalid', false);

        _.each(attributesTypes, function (attributeType) {
            let customScope = getCustomScope(attributeType),
                container;

            result = _.extend(result, armahCheckoutProvider.get(attributeType));
            armahCheckoutProvider.trigger(customScope + '.data.validate');

            if (!hideError && !focused && armahCheckoutProvider.get('params.invalid')) {
                container = registry.filter("index = " + attributeType + 'Container');
                if (container.length) {
                    container[0].focusInvalidField();
                }
                focused = true;
            }
        }, this);

        if (armahCheckoutProvider.get('params.invalid')) {
            if (hideError) {
                //set current value as initialValue
                armahCheckoutProvider.trigger('data.overload');
                //set initialValue to value and reset errors
                armahCheckoutProvider.trigger('data.reset');
            }

            return false;
        } else {
            return result;
        }
    }
});
