define(["Magento_Checkout/js/view/shipping"], function (Component) {
    'use strict';

    return Component.extend({
        setShippingInformation: function () {
            /** @TODO use dynamic url */
            ga('send', 'pageview', '/checkout/#payment');
            this._super();
        }
    });
});
