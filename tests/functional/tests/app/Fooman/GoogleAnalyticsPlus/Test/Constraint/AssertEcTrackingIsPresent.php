<?php
/**
 * @author     Kristof Ringleff
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fooman\GoogleAnalyticsPlus\Test\Constraint;

use Magento\Checkout\Test\Page\CheckoutOnepageSuccess;


class AssertEcTrackingIsPresent extends \Magento\Mtf\Constraint\AbstractConstraint
{

    const GA_EC = "ga('ec:setAction', 'purchase'";

    /**
     * Assert that success message is correct
     *
     * @param CheckoutOnepageSuccess $checkoutOnepageSuccess
     * @return void
     */
    public function processAssert(CheckoutOnepageSuccess $checkoutOnepageSuccess)
    {
        \PHPUnit_Framework_Assert::assertContains(
            self::GA_EC,
            $checkoutOnepageSuccess->getFoomanBody()->getGaScript(),
            'Ecommerce Tracking is not present.'
        );
    }

    /**
     * Returns string representation of successful assertion
     *
     * @return string
     */
    public function toString()
    {
        return 'Ecommerce Tracking is present.';
    }
}
