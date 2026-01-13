/**
 * Autocomplete element field
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'Armah_GoogleAddressAutocomplete/js/autocomplete'
], function (AbstractField, autocomplete) {
    'use strict';

    return AbstractField.extend({
        initialize: function () {
            this._super();

            autocomplete.registerField(this.name.split('.').slice(0, -2).join('.'));

            return this;
        }
    });
});
