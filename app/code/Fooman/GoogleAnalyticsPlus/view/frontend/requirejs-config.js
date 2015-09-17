var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Fooman_GoogleAnalyticsPlus/js/action/place-order': true
            }
        }
    },
    deps: [
        "Fooman_GoogleAnalyticsPlus/js/view/shipping",
    ]
};
