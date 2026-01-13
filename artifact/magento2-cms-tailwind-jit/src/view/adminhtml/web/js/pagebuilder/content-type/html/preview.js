/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */
define(
    ['Magento_PageBuilder/js/content-type/html/preview', 'mage/url'],
    function (PreviewBase, url) {
        'use strict';

        function updatePreviewIframe(iframe, html) {
            const doc = iframe.contentWindow.document;
            if (navigator.userAgent.includes('Firefox')) {
              // Allow setting of iframe with initially empty content
              doc.open();
              doc.close();
            }
            const adminConfig = window.tailwindCSS && window.tailwindCSS.configForAdminPreview() || '{corePlugins: {preflight: true}}';
            const customCss = window.tailwindCSS && window.tailwindCSS.customCssForAdminPreview() || '';
            const previewStylesId = 'jit-styles';

            tailwindCSS.process(html, adminConfig, customCss).then((css) => {
                let style = doc.getElementById(previewStylesId);
                if (style === null) {
                    style = doc.createElement('style');
                    style.id = previewStylesId;
                    doc.head.append(style);
                }
                style.textContent = css;
            });
            doc.body.innerHTML = html;
            adjustHeight(iframe);
        }

        function adjustHeight(iframe) {
            // wait a few ms before fetching the height so the DOM has time to process the content update.
            setTimeout(() => {
                const doc = iframe.contentWindow.document;
                const height = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
                iframe.style.height = height + 'px';
            }, 50)
        }


        const HtmlPreview = function () {

            this.isJitPreviewEnabled = function() {
                return window.tailwindCSS && window.tailwindCSS.isTailwindJitEnabled();
            }

            this.updatePreview = function () {
                if (!this.iframe || !this.iframe.contentWindow) return;

                const cssClasses = Object.entries(this.data.main.css())
                    .filter(([cls, isPresent]) => isPresent)
                    .map(([cls]) => cls)
                    .join(' ');

                const html = this.data.main.html().replaceAll(/{{\s*media\s+url=(['"]?)(?<url>[^}]+)\1}}/g, function () {
                    return url.build('/media/' + arguments[arguments.length -1].url)
                })

                updatePreviewIframe(this.iframe, `<div class="${cssClasses}">${html}</div>`)
            }

            this.initPreviewHtml = function(iframe) {
                this.iframe = iframe;
                this.data.main.css.subscribe(() => this.updatePreview());
                this.data.main.html.subscribe(() => this.updatePreview());
                this.updatePreview();
            }

            const instance = PreviewBase.apply(this, arguments) || this;
            window.addEventListener('cms-tailwind-jit-update-admin-preview', () => instance.updatePreview());
            return instance;
        }

        HtmlPreview.prototype = Object.create(PreviewBase.prototype);

        return HtmlPreview;
    }
);
