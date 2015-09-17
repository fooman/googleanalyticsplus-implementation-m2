var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Fooman_GoogleAnalyticsPlus/js/action/place-order': true
            },
            'Magento_Checkout/js/view/shipping': {
                'Fooman_GoogleAnalyticsPlus/js/view/shipping': true
            }
        }
    }
};
