define([
    'underscore',
    'Magento_Ui/js/form/element/abstract',
    'Armah_Orderattr/js/form/relationAbstract'
], function (_, Abstract, relationAbstract) {
    'use strict';

    // relationAbstract - attribute dependencies
    return Abstract.extend(relationAbstract).extend({

        /**
         * Retrieves preview element value
         *
         * @returns {boolean}
         */
        getPreviewValue: function () {
            return false;
        }
    });
});
