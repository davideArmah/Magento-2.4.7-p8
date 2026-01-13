define([
    'jquery',
    'stickyWidget',
    'checkoutCollapsibleSteps'
], function ($) {
    'use strict';

    $.widget('armah.summaryWidget', {
        options: {
            desktopBreakpoint: 1024,
        },

        _create: function () {
            if ($(this.element).parents('[data-archeckout-js="main-container"]').length) {
                this.summaryByLayout();
            }
        },

        summaryByLayout: function () {
            switch (window.checkoutLayout) {
                case '1column':
                    $(this.element).checkoutCollapsibleSteps();
                    break;

                case '2columns':
                    this.manageCollapsible();
                    if (!$(this.element).data('armahStickyWidget')) {
                        $(this.element).stickyWidget({
                            parentContainer: '[data-archeckout-js="main-container"]',
                            element: '[data-archeckout-js="sidebar-column"]',
                            scrollContentContainer: '[data-archeckout-js="main-column"]',
                            stickyOffset: {
                                top: 0,
                                left: 60
                            },
                            stickyPosition: 'right'
                        });
                    }
                    break;

                default:
                    break;
            }
        },

        manageCollapsible: function () {
            if ($(window).width() < this.options.desktopBreakpoint) {
                $(this.element).checkoutCollapsibleSteps();
            } else {
                $('[data-archeckout-js="step-container"]').on("dimensionsChanged", function () {
                    $(window).trigger('scroll');
                });
            }

            $(window).on('resize', function () {
                if ($(window).width() < this.options.desktopBreakpoint) {
                    $(this.element).checkoutCollapsibleSteps().checkoutCollapsibleSteps('createCollapsible');
                } else {
                    if ($(this.element).data('armahCheckoutCollapsibleSteps')) {
                        $(this.element).checkoutCollapsibleSteps('destroyCollapsible');
                    }
                }
            }.bind(this));
        }
    });

    return $.armah.summaryWidget;
});
