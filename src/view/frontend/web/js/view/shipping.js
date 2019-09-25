/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
define(function () {
    'use strict';

    return function (target) {
        return target.extend({
            setShippingInformation: function () {
                if (typeof(ga) != "undefined") {
                    var urlToTrack = foomanGaBaseUrl + '/payment';
                    if (location.search.length > 0) {
                        urlToTrack += location.search
                    }
                    ga('set', 'page', urlToTrack);
                    ga('send', 'pageview');
                }
                this._super();
            }
        });
    }
});
