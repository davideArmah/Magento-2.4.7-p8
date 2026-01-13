/**
 *  Armah Base Search UI Component
 */

define([
    'ko',
    'uiElement'
], function (ko, Element) {
    'use strict';

    return Element.extend({
        defaults: {
            template: 'Armah_Base/submenu/components/search',
            links: {
                solutions: 'arbase_solutions:elems',
                simples: 'arbase_simples:elems',
                links: 'arbase_links:elems'
            },
            exports: {
                noSearchResults: 'arbase_submenu:noSearchResults',
                solutionNotFound: 'arbase_solutions:isNotFound',
                simplesNotFound: 'arbase_simples:isNotFound',
                linksNotFound: 'arbase_links:isNotFound'
            },
            listens: {
                value: 'onValueChanged'
            }
        },

        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe({
                    value: '',
                    noSearchResults: false,
                    simplesNotFound: false,
                    solutionNotFound: false,
                    linksNotFound: false
                });

            this.noSearchResults = ko.computed(function () {
                return this.simplesNotFound() && this.solutionNotFound() && this.linksNotFound()
            }.bind(this));

            return this;
        },

        /**
         * On value change handler
         *
         * @param {String} value
         * @return {void}
         */
        onValueChanged: function (value) {
            if (value.length !== 1) {
                this.solutionNotFound(!this.search(this.solutions, value));
                this.simplesNotFound(!this.search(this.simples, value));
                this.linksNotFound(!this.search(this.links, value));
            }
        },

        /**
         * Search value in menu items
         *
         * @param {Array} items
         * @param {String} value
         * @return {Boolean}
         */
        search: function (items, value) {
            var isFoundItem = false,
                isMatch;

            items.forEach(function (item) {
                item.foundStr('');
                isMatch = item.onSearchQuery(value.toLowerCase());

                if (isMatch) {
                    isFoundItem = isMatch;
                }
            }.bind(this));

            return isFoundItem;
        },

        /**
         * Clear search value
         *
         * @return {void}
         */
        cancel: function () {
            this.value('');
        }
    });
});
