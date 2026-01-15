/**
 *  Armah Base Submenu Items UI Component
 */

define([
    'ko',
    'uiComponent',
    'Armah_Base/js/actions/createMenuItem'
], function (ko, Component, createMenuItem) {
    'use strict';

    return Component.extend({
        defaults: {
            vendorName: 'Armah',
            templates: {
                label: 'Armah_Base/submenu/components/label',
                list: 'Armah_Base/submenu/list',
                dropdown: 'Armah_Base/submenu/dropdown/dropdown',
                dropdownContent: 'Armah_Base/submenu/dropdown/content'
            },
            elemIndex: 0,
            solutions: [],
            simples: [],
            listens: {
                data: 'initChild'
            }
        },

        /** @inheritdoc */
        initObservable: function () {
            return this._super()
                .observe({
                    secondLevelItem: false,
                    isDropdownActive: false,
                    isNotFound: false
                });
        },

        /**
         * Init menu items
         *
         * @return {void}
         */
        initChild: function () {
            this.data.forEach(function (item) {
                createMenuItem.call(this, item, this.elemIndex);
                this.elemIndex += 1;
            }.bind(this));
        }
    });
});
