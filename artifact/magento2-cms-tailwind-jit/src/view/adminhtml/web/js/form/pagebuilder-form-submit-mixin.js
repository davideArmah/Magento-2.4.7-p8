/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

define([
  'jquery',
  'Magento_PageBuilder/js/events'
], function ($, events) {
  'use strict';

  return function (target) {

    return target.extend({

      defaults: {
        pageBuilderInstances: []
      },

      /**
       * Record instances of Page Builder initialized in the forms namespace
       */
      initialize: function () {
        this._super();

        events.on('pagebuilder:register', (data) => {
          if (data.ns === this.ns) {
            this.pageBuilderInstances.push(data.instance);
          }
        });

        return this;
      },

      /**
       * Ensure any Page Builder rendering is completed before generating tailwind styles and submitting form
       *
       * @see Magento_PageBuilder/view/adminhtml/web/js/form/form-mixin.js
       */
      save: function (redirect, data) {
        const submit = this._super.bind(this, redirect, data);

        if (this.pageBuilderInstances.length === 0 || !window.tailwindCSS || !window.tailwindCSS.updateFrontendStyles) {
          submit();
        } else {
          let locks;
          $('body').trigger('processStart');

          // Wait for all rendering locks within Page Builder stages to resolve
          $.when.apply(
            null,
            this.pageBuilderInstances.map(function (instance) {
              locks = instance.stage.renderingLocks;

              return locks[locks.length - 1];
            })
          ).then(function () {
            $('body').trigger('processStop');
            window.tailwindCSS.updateFrontendStyles().then(() => {
              submit()
            })
          });
        }
      }
    });
  };
});
