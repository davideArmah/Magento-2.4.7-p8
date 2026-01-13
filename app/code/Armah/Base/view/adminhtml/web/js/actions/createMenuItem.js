/**
 *  Armah Base Create Menu Item Action
 */

define([
    'mageUtils',
    'uiLayout'
], function (utils, layout) {
    'use strict';

    /**
     * Create Ui Item
     *
     * @param {Object} data
     * @param {number} index
     * @return {void}
     */
    return function (data, index) {
        var field;

        field = utils.extend(data, {
            'name': this.name + '.' + index,
            'component': 'Armah_Base/js/menu/item',
            'template': data.type === 'solution' ? this.templates.dropdown : 'Armah_Base/submenu/components/menu_item',
            'provider': this.provider
        });

        layout([field]);
        this.insertChild(field.name);
    };
});
