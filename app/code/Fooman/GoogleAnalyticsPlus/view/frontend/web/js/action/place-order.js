define(['mage/utils/wrapper'], function (wrapper) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, redirectOnSuccess) {
            /** @TODO use dynamic url */
            ga('send', 'pageview', '/checkout/#place');
            return originalAction(paymentData, redirectOnSuccess);
        });
    };
});
