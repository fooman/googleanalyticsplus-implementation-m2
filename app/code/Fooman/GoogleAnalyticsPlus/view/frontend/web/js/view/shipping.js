define(function () {
    'use strict';

    return function (target) {
        return target.extend({
            setShippingInformation: function () {
                /** @TODO use dynamic url */
                ga('send', 'pageview', '/checkout/#payment');
                this._super();
            }
        });
    }
});
