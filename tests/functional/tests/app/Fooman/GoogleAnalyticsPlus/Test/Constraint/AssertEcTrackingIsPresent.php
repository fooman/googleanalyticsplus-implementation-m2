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

    /**
     *  From Magento 2.2 a Magento text/x-magento-init block is used
     *  by the time Selenium can access it, the block has already been processed
     *  and removed from the DOM. Let's keep this test to check for presence of the
     *  markers around the block
     *
     * @see \Fooman\GoogleAnalyticsPlus\Test\Block\Onepage\Body
     */
    const GA_EC = '<!--BEGINGOOGLEANALYTICSCODE--><!--ENDGOOGLEANALYTICSCODE-->';

    /**
     * Assert that purchase tracking code appears in the ga script
     *
     * @param CheckoutOnepageSuccess $checkoutOnepageSuccess
     * @return void
     */
    public function processAssert(CheckoutOnepageSuccess $checkoutOnepageSuccess)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            str_replace([PHP_EOL, ' '], '', $checkoutOnepageSuccess->getFoomanBody()->getGaScript()),
            self::GA_EC,
            'Ecommerce Tracking is not present. |' . str_replace(
                [PHP_EOL, ' '], '', $checkoutOnepageSuccess->getFoomanBody()->getGaScript()
            ) . '|'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'Ecommerce Tracking is present.';
    }
}
