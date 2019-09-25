/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
define(['mage/utils/wrapper'], function (wrapper) {
    'use strict';

    return function (target) {
        target.getRates = wrapper.wrap(target.getRates, function (originalAction, address) {
            if (typeof(ga) != "undefined") {
                var urlToTrack = foomanGaBaseUrl + '/get-shipping-rates';
                if (location.search.length > 0) {
                    urlToTrack += location.search
                }
                ga('set', 'page', urlToTrack);
                ga('send', 'pageview');
            }
            return originalAction(address);
        });
        return target;
    };
});

