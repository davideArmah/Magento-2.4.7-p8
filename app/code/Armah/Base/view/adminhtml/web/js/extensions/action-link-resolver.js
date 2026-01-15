define([
    'mage/translate'
], function ($t) {
    'use strict';

    /**
     * @typedef {Object} ActionLinkData
     * @property {string|null} text
     * @property {string|null} url
     */

    return {
        /**
         * @param {ModuleInfo} module
         * @return {ActionLinkData}
         */
        getActionLinkData: function (module) {
            let actionLinkData = {
                text: null,
                url: null
            }

            if (module.upgrade_url) {
                actionLinkData = {
                    text: $t('Upgrade Your Plan'),
                    url: module.upgrade_url
                }
            }

            return actionLinkData;
        }
    }
});
