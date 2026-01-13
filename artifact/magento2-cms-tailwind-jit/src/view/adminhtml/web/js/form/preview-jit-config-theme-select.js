/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */
define(['Magento_Ui/js/form/element/select'], function (Select) {
    'use strict';

    return Select.extend({
        defaults: {
            listens: {
                'ns = ${ $.ns }, index=is_tailwindcss_jit_enabled:value': 'visibilityChange'
            },
            statefull: {
                value: true
            },
            storageConfig: {
                // share storage value across pages as long as the component index is the same
                namespace: 'cms_jit_preview_theme'
            }
        },
        visibilityChange: function (v) {
            this.disabled(0 === parseInt(v));
        },
        initialize: function () {
            this._super();
            this.value.subscribe(() => {
                window.dispatchEvent(new CustomEvent('cms-tailwind-jit-update-admin-preview'));
            });
            return this;
        }
    })
})
