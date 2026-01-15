/**
 *  Armah Theme Mixin
 */

define([
    'jquery',
    'uiRegistry'
], function ($, registry) {
    'use strict';

    return function (widget) {
        $.widget('mage.globalNavigation', widget, {
            options: {
                components: {
                    arbase_submenu: 'index = arbase_submenu'
                }
            },

            /**
             * Extended creating widget functionality via adding Armah submenu
             * uiComponent from Armah module
             *
             * @private
             * @return {void}
             */
            _create: function () {
                registry.get(this.options.components.arbase_submenu, function (arbase_submenu) {
                    this.options.components.arbase_submenu = arbase_submenu;
                }.bind(this));

                this._super();
            },

            /**
             * Extended close functionality with clearing second level of submenu
             * from Armah module
             *
             * @param {jQuery.Event} event
             * @private
             * @return {void}
             */
            _close: function (event) {
                if (this.options.components.arbase_submenu.resetActiveItem) {
                    this.options.components.arbase_submenu.resetActiveItem();
                }
                this._super(event);
            },

            /**
             * Extended open functionality with clearing second level of submenu
             * from Armah module
             *
             * @param {jQuery.Event} event
             * @private
             * @return {void}
             */
            _open: function (event) {
                if (this.options.components.arbase_submenu.resetActiveItem) {
                    this.options.components.arbase_submenu.resetActiveItem();
                }
                this._super(event);
            }
        });

        return $.mage.globalNavigation;
    }
});
