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
    private $helper;
    private $urlHelper;

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
     * @param                                   $result
     *
     * @return string
     */
    public function afterGetPageTrackingData(
        \Magento\GoogleAnalytics\Block\Ga $subject,
        $result
    ) {
        $result['isDisplayFeaturesActive'] = (int)$this->helper->isDisplayAdvertisingEnabled();
        $result['optPageUrl'] = $this->getPageName($subject);
        $result['isEnhancedLinksActive'] = (int)$this->helper->isEnhancedLinkAttrEnabled();
        return $result;
    }

    /**
     * @param \Magento\GoogleAnalytics\Block\Ga $subject
     *
     * @return array|string
     */
    protected function getPageName(\Magento\GoogleAnalytics\Block\Ga $subject)
    {
        return $subject->escapeUrl($this->urlHelper->getUnifiedPageName($subject->getPageName()));
    }
}
