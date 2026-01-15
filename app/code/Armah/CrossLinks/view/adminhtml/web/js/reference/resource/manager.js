define([
    'jquery'
], function ($) {
    'use strict';

    const REFERENCE_CUSTOM_TYPE = 0;
    const REFERENCE_PRODUCT_TYPE = 1;
    const REFERENCE_CATEGORY_TYPE = 2;

    window.ResourceManager = {
        config: {
            catalogFieldSelector: '#reference_resource_catalog_field',
            categoryPickerContainerSelector: '.control-category-picker',
            productPickerContainerSelector: '.control-product-picker',
            referenceResourceSelector: '#reference_resource',
            referenceTypeSelector: '#reference_type',
            referenceResourceText: '',
            referenceResourceValue: null
        },

        /**
         * @param {Object} config
         */
        init: function (config) {
            $.extend(this.config, config || {});
            this.initEventListeners();
            this.initResourceReference();
            $(this.config.catalogFieldSelector).prop('disabled', true);
        },

        /**
         * @param {string} value
         */
        setResourceValue: function (value) {
            $(this.config.catalogFieldSelector).prop('disabled', false).val(value);
        },

        /**
         * @param {int} value
         * @returns {Window.ResourceManager}
         */
        showResourceName: function (value) {
            $(this.config.referenceResourceSelector).val(value);
            $(this.config.referenceResourceSelector).prop('disabled', true);
            return this;
        },

        hidePickers: function () {
            $(this.config.categoryPickerContainerSelector).hide();
            $(this.config.productPickerContainerSelector).hide();
            return this;
        },

        initEventListeners: function () {
            $(this.config.referenceTypeSelector).bind('change', this.initResourceReference.bind(this));
            return this;
        },

        initResourceReference: function () {
            this.hidePickers();
            let referenceType = $(this.config.referenceTypeSelector).val();
            switch (parseInt(referenceType)) {
                case REFERENCE_CUSTOM_TYPE:
                    this.initCustomReference();
                    break;
                case REFERENCE_PRODUCT_TYPE:
                    this.initProductReference();
                    break;
                case REFERENCE_CATEGORY_TYPE:
                    this.initCategoryReference();
                    break;
                default:
                    break;
            }
            return this;
        },

        initCustomReference: function () {
            $(this.config.catalogFieldSelector).prop('disabled', true);
            $(this.config.referenceResourceSelector).prop('disabled', false);
        },

        initCategoryReference: function () {
            this.prepareReferenceToInit();
            $(this.config.categoryPickerContainerSelector).show();
        },

        initProductReference: function () {
            this.prepareReferenceToInit();
            $(this.config.productPickerContainerSelector).show();
        },

        prepareReferenceToInit: function () {
            $(this.config.referenceResourceSelector).val('');
            $(this.config.catalogFieldSelector).prop('disabled', false);
            $(this.config.referenceResourceSelector).prop('disabled', true);
            $(this.config.referenceResourceSelector).val(this.config.referenceResourceText);
            $(this.config.catalogFieldSelector).val(this.config.referenceResourceValue);
        }
    };

    return window.ResourceManager
});