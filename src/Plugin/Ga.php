<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\GoogleAnalyticsPlus\Plugin;

class Ga
{
    protected $helper;
    protected $urlHelper;

    /**
     * @param \Fooman\GoogleAnalyticsPlus\Helper\Config $helper
     */
    public function __construct(
        \Fooman\GoogleAnalyticsPlus\Helper\Config $helper,
        \Fooman\GoogleAnalyticsPlus\Helper\Url $urlHelper
    ) {
        $this->helper = $helper;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @param \Magento\GoogleAnalytics\Block\Ga $subject
     * @param \Closure                          $proceed
     * @param                                   $accountId
     *
     * @return string
     */
    public function aroundGetPageTrackingCode(
        \Magento\GoogleAnalytics\Block\Ga $subject,
        \Closure $proceed,
        $accountId
    ) {
        $gaLines = [];
        $gaLines[] = sprintf("ga('create', '%s', 'auto');", $subject->escapeJsQuote($accountId));

        if ($this->helper->isAnonymiseEnabled()) {
            $gaLines[] = "ga('set', 'anonymizeIp', true);";
        }

        if ($this->helper->isDisplayAdvertisingEnabled()) {
            $gaLines[] = "ga('require', 'displayfeatures');";
        }

        if ($this->helper->isEnhancedLinkAttrEnabled()) {
            $gaLines[] = "ga('require', 'linkid');";
        }

        $gaLines[] = sprintf("ga('set', 'page', '%s');", $this->getPageName($subject));

        //Page view is sent in getOrdersTrackingCode if order is placed, don't send it twice
        if ($this->shouldSendPageView($subject)) {
            $gaLines[] = "ga('send', 'pageview');";
        }

        //we can't use $proceed($accountId) here as it would include the original output
        //doubling up the number of tracked pages
        return implode("\n    ", $gaLines);
    }

    /**
     * @param \Magento\GoogleAnalytics\Block\Ga $subject
     *
     * @return bool
     */
    protected function shouldSendPageView(\Magento\GoogleAnalytics\Block\Ga $subject)
    {
        $orderIds = $subject->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return true;
        }
        return false;
    }

    /**
     * @param \Magento\GoogleAnalytics\Block\Ga $subject
     *
     * @return array|string
     */
    protected function getPageName(\Magento\GoogleAnalytics\Block\Ga $subject)
    {
        return $subject->escapeJsQuote($this->urlHelper->getUnifiedPageName($subject->getPageName()));
    }
}
