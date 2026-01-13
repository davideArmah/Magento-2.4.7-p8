/* jshint browser:true jquery:true */
/* global alert */
var config = {
    map: {
        '*': {
            armahSectionsRate: 'Armah_CheckoutCore/js/reports/sections-rate',
            arCharts: 'Armah_CheckoutCore/vendor/archarts/archarts',
            arChartsSerial: 'Armah_CheckoutCore/vendor/archarts/serial'
        }
    },
    shim: {
        'Armah_CheckoutCore/vendor/archarts/serial': [ 'Armah_CheckoutCore/vendor/archarts/archarts' ]
    }
};
