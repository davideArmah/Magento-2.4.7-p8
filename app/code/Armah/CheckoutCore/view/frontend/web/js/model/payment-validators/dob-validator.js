
define([
    'uiRegistry'
], function (registry) {
    'use strict';

    return {
        /**
         * Validate Date of Birth if available
         *
         * @returns {Boolean}
         */
        validate: function () {
            var armahDob = registry.get('checkout.sidebar.additional.checkboxes.date_of_birth');

            if (armahDob && armahDob.visible()) {
                var validate = armahDob.validate();
                if (validate == false) {
                    return false;
                }
                return validate.valid;
            }

            return true;
        }
    };
});
