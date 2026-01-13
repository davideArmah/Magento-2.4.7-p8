/**
 *  Armah Base Submenu UI Component
 */

define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            vendorName: 'Armah',
            templates: {
                closeButton: 'Armah_Base/submenu/components/close_button',
                link: 'Armah_Base/submenu/components/link',
                title: 'Armah_Base/submenu/components/title',
                submenuSecond: 'Armah_Base/submenu/second_level',
                menu_lists: 'Armah_Base/submenu/menu_lists',
                links_list: 'Armah_Base/submenu/links_list',
                item_label: 'Armah_Base/submenu/components/item_label',
            },
            elemIndex: 0,
            exports: {
                solutions: 'arbase_solutions:data',
                simples: 'arbase_simples:data',
                links: 'arbase_links:data'
            }
        },

        /** @inheritdoc */
        initObservable: function () {
            return this._super()
                .observe({
                    secondLevelItem: false,
                    isDropdownActive: false,
                    noSearchResults: false,
                    simples: [],
                    solutions: [],
                    links: []
                });
        },

        /**
         * Splits data into different arrays
         *
         * @return {void}
         */
        afterRender: function () {
            var simples = [],
                solutions = [],
                links = [];

            this.data.forEach(function (item) {
                if (item.type === 'simple') {
                    simples.push(item);
                } else if (item.type === 'link') {
                    links.push(item);
                } else {
                    solutions.push(item);
                }
            }.bind(this));

            this.simples(simples);
            this.solutions(solutions);
            this.links(links);
        },

        /**
         * Set active item for second level
         *
         * @param {Object} item - target item
         * @return {void}
         */
        setActiveItem: function (item) {
            this.resetActiveItem();
            this.secondLevelItem(item);
        },

        /**
         * Reset active item for second level
         *
         * @return {void}
         */
        resetActiveItem: function () {
            this.secondLevelItem(false);
        }
    });
});
