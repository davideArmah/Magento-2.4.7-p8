define([
    'jquery',
    'mage/collapsible'
], function ($) {

    $.widget('mage.arCheckoutCollapsible', $.mage.collapsible, {
        _create: function () {
            // WCAG compatibility
            this.options.content = $(this.element).find(this.options.content);
            this._super();
        }
    });

    return $.mage.arCheckoutCollapsible;
});
