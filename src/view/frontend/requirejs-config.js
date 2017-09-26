/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
var config = {
    map: {
        '*': {
            'Magento_GoogleAnalytics/js/google-analytics': 'Fooman_GoogleAnalyticsPlus/js/google-analytics'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Fooman_GoogleAnalyticsPlus/js/action/place-order': true
            },
            'Magento_Checkout/js/view/shipping': {
                'Fooman_GoogleAnalyticsPlus/js/view/shipping': true
            },
            'Magento_Customer/js/action/check-email-availability': {
                'Fooman_GoogleAnalyticsPlus/js/action/check-email-availability': true
            },
            'Magento_Checkout/js/model/shipping-rate-processor/new-address': {
                'Fooman_GoogleAnalyticsPlus/js/model/shipping-rate-processor/new-address': true
            },
            'Magento_Checkout/js/model/shipping-rate-processor/customer-address' : {
                'Fooman_GoogleAnalyticsPlus/js/model/shipping-rate-processor/customer-address': true
            }
        }
    }
};
