define([
    'ko',
    'underscore',
    'uiRegistry',
    'Armah_Orderattr/js/form/relationRegistry'
], function (ko, _, registry, relationRegistry) {
    'use strict';

    /**
     * @abstract
     */
    return {
        defaults: {
            visibilityVariables: {
                arHidedByDepend: false,
                arHidedByRate: false
            }
        },

        hidedByRate: false,
        originVisibility: function () {},

        /**
         * @param {Object[]} relations
         * @param {string} relations[].attribute_name - element name of parent attribute
         * @param {string} relations[].dependent_name - element name of depend attribute
         * @param {string} relations[].option_value   - value which Parent should have to show Depend
         */
        relations: {},

        isRelationsInit: false,

        initObservable: function () {
            this._super()
                .observe(this.visibilityVariables);

            return this;
        },

        initialize: function () {
            this._super()
                .initVisibilityComputed();

            this.initCheck();

            return this;
        },

        initVisibilityComputed: function () {
            if (this.visible()) {
                this.originVisibility = this.visible;

                this.visible = ko.pureComputed({
                    write: function (value) {
                        this.originVisibility(value);
                    }.bind(this),
                    read: this.visibilityCallback.bind(this)
                });

                this.visible.subscribe((isVisible) => {
                    if (this.isRelationsInit) {
                        this.checkDependencies();
                    }
                });
            }
        },

        visibilityCallback: function () {
            let isVisible = true;

            if (!this.originVisibility()) {
                return false;
            }

            Object.keys(this.visibilityVariables).forEach(key => {
                if (ko.isObservable(this[key]) && this[key]()) {
                    isVisible = false;
                }
            });

            return isVisible;
        },

        /**
         * check attribute dependencies on value change
         */
        onUpdate: function () {
            this._super();
            if (this.isRelationsInit) {
                this.checkDependencies();
            }
        },

        /**
         * run check dependency and clear relations
         */
        initCheck: function () {
            if (this.relations && this.relations.length) {
                this.isRelationsInit = true;
                this.checkDependencies();
            }
        },

        checkDependencies: function () {
            var listDisplayedUID = [];

            if (this.relations && this.relations.length) {
                registry.async(this.parentName)(function (fieldset) {
                    this.relations.map(function (relation) {
                        registry.async(fieldset.name + '.' + relation.dependent_name)(function (dependElement) {
                            if (this.isCanShow(relation)) {
                                listDisplayedUID.push(dependElement.uid);
                                this.showDepend(dependElement);
                            } else if (listDisplayedUID.indexOf(dependElement.uid) === -1) {
                                /** hide element only if no relation rules to show. On one check */
                                this.hideDepend(dependElement);
                            }
                        }.bind(this));
                    }.bind(this));
                }.bind(this));
            }
        },

        /**
         * Is element value eq relation value
         *
         * @param relation
         * @returns {boolean}
         */
        isCanShow: function (relation) {
            if (_.isArray(this.value())) {
                return _.contains(this.value(), relation.option_value) && this.visible();
            }

            return this.value() === relation.option_value && this.visible();
        },

        showDepend: function (dependElement) {
            relationRegistry.add(dependElement.index, this.index);
            dependElement.arHidedByDepend(false);
        },

        hideDepend: function (dependElement) {
            relationRegistry.remove(dependElement.index, this.index);

            if (!relationRegistry.isExist(dependElement.index)) {
                dependElement.arHidedByDepend(true);
            }
        }
    };
});
