<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Debug\System;

/**
 * @codeCoverageIgnore
 * @codingStandardsIgnoreFile
 */
class Template
{
    public static $varWrapper = '<div class="armah-base-debug-wrapper"><code>%s</code></div>';

    public static $string = '"<span class="armah-base-string">%s</span>"';

    public static $var = '<span class="armah-base-var">%s</span>';

    public static $arrowsOpened =  '<span class="armah-base-arrow" data-opened="true">&#x25BC;</span>
        <div class="armah-base-array">';

    public static $arrowsClosed = '<span class="armah-base-arrow" data-opened="false">&#x25C0;</span>
        <div class="armah-base-array armah-base-hidden">';

    public static $arrayHeader = '<span class="armah-base-info">array:%s</span> [';

    public static $array = '<div class="armah-base-array-line" style="padding-left:%s0px">
            %s  => %s
        </div>';

    public static $arrayFooter = '</div>]';

    public static $arrayKeyString = '"<span class="armah-base-array-key">%s</span>"';

    public static $arrayKey = '<span class="armah-base-array-key">%s</span>';

    public static $arraySimpleVar = '<span class="armah-base-array-value">%s</span>';

    public static $arraySimpleString = '"<span class="armah-base-array-string-value">%s</span>"';

    public static $objectHeader = '<span class="armah-base-info" title="%s">Object: %s</span> {';

    public static $objectMethod = '<div class="armah-base-object-method-line" style="padding-left:%s0px">
            #%s
        </div>';

    public static $objectMethodHeader = '<span style="margin-left:%s0px">Methods: </span>
        <span class="armah-base-arrow" data-opened="false">◀</span>
        <div class="armah-base-array  armah-base-hidden">';

    public static $objectMethodFooter = '</div>';

    public static $objectFooter = '</div> }';

    public static $debugJsCss = '<script>
            var armahToggle = function() {
                if (this.dataset.opened == "true") {
                    this.innerHTML = "&#x25C0";
                    this.dataset.opened = "false";
                    this.nextElementSibling.className = "armah-base-array armah-base-hidden";
                } else {
                    this.innerHTML = "&#x25BC;";
                    this.dataset.opened = "true";
                    this.nextElementSibling.className = "armah-base-array";
                }
            };
            document.addEventListener("DOMContentLoaded", function() {
                arrows = document.getElementsByClassName("armah-base-arrow");
                for (i = 0; i < arrows.length; i++) {
                    arrows[i].addEventListener("click", armahToggle,false);
                }
            });
        </script>
        <style>
            .armah-base-debug-wrapper {
                background-color: #263238;
                color: #ff9416;
                font-size: 13px;
                padding: 10px;
                border-radius: 3px;
                z-index: 1000000;
                margin: 20px 0;
            }
            .armah-base-debug-wrapper code {
                background: transparent !important;
                color: inherit !important;
                padding: 0;
                font-size: inherit;
                white-space: inherit;
            }
            .armah-base-info {
                color: #82AAFF;
            }
            .armah-base-var, .armah-base-array-key {
                color: #fff;
            }
            .armah-base-array-value {
                color: #C792EA;
                font-weight: bold;
            }
            .armah-base-arrow {
                cursor: pointer;
                color: #82aaff;
            }
            .armah-base-hidden {
                display:none;
            }
            .armah-base-string, .armah-base-array-string-value {
                font-weight: bold;
                color: #c3e88d;
            }
            .armah-base-object-method-line {
                color: #fff;
            }
        </style>';
}
