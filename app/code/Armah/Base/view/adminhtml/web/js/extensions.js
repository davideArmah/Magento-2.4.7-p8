/**
 *  Armah Base Extensions UI Component
 */

define([
    'uiComponent',
    'mage/translate',
    'Armah_Base/js/extensions/action-link-resolver'
], function (Component, $t, actionLinkResolver) {
    'use strict';

    /**
     * @typedef {Object} ModuleInfo
     * @property {string} code
     * @property {string} name
     * @property {boolean} has_update
     * @property {boolean} is_solution
     * @property {string} version
     * @property {string} last_version
     * @property {[{ type: string, content: string }]} messages
     * @property {string} module_url
     * @property {string} update_url
     * @property {string} upgrade_url
     * @property {string} plan_label
     */

    return Component.extend({
        defaults: {
            template: 'Armah_Base/extensions/extensions',
            templates: {
                updateButtons: 'Armah_Base/extensions/update-buttons',
                filterButtons: 'Armah_Base/extensions/filter-buttons',
                table: 'Armah_Base/extensions/table'
            },
            modulesData: [],
            update: [],
            solutions: [],
            stateValues: {
                default: 'default',
                solutions: 'solutions',
                update: 'update'
            }
        },

        /**
         * @inheritdoc
         */
        initialize: function () {
            this._super();

            this.update = this.prepareModules(this.modulesData.filter(function (item) {
                return item.has_update;
            }));

            this.solutions = this.prepareModules(this.modulesData.filter(function (item) {
                return item.upgrade_url;
            }));

            this.modules(this.prepareModules(this.modulesData));

            return this;
        },

        /**
         * @inheritdoc
         */
        initObservable: function () {
            return this._super()
                .observe({
                    state: 'default',
                    modules: []
                });
        },

        /**
         * Use Extensions Filter
         *
         * @param {String} state
         * @returns {void}
         */
        useGridFilter: function (state) {
            this.state(state);

            if (this.stateValues.default === state) {
                this.modules(this.prepareModules(this.modulesData));

                return;
            }

            this.modules(this[state]);
        },

        /**
         * Is filter active
         *
         * @param {String} state
         * @returns {Boolean}
         */
        isActive: function (state) {
            return this.state() === state;
        },

        /**
         * Prepare modules data
         *
         * @param {Array} data
         * @returns {Array}
         */
        prepareModules: function (data) {
            var availableUpgrade = data.filter(function (item) {
                    return item.upgrade_url;
                }),
                needUpdate = data.filter(function (item) {
                    return item.has_update && !item.upgrade_url;
                }),
                modules = data.filter(function (item) {
                    return !item.has_update && !item.upgrade_url;
                });

            return availableUpgrade.concat(needUpdate, modules);
        },

        /**
         * @param {ModuleInfo} module
         * @returns {ActionLinkData}
         */
        getActionLink: function (module) {
            return actionLinkResolver.getActionLinkData(module);
        }
    });
});
