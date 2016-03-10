<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fooman\GoogleAnalyticsPlus\Test\Block\Onepage;

use Magento\Checkout\Test\Fixture\Checkout;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class Success
 * One page checkout success block
 */
class Body extends Block
{

    const GA_MARKER_START = '<!-- BEGIN GOOGLE ANALYTICS CODE -->';
    const GA_MARKER_END = '<!-- END GOOGLE ANALYTICS CODE -->';

    public function getGaScript()
    {
        $body = $this->_rootElement->getAttribute('innerHTML');
        $start = strpos($body, self::GA_MARKER_START);
        $end = strpos($body, self::GA_MARKER_END) + strlen(self::GA_MARKER_END);
        return PHP_EOL . substr($body, $start, $end - $start) . PHP_EOL;
    }
}

