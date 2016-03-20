<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\GoogleAnalyticsPlus\Helper;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_UNIVERSAL_ANONYMISE = 'google/analyticsplus_universal/anonymise';
    const XML_PATH_UNIVERSAL_DISPLAY_ADS = 'google/analyticsplus_universal/display_advertising';
    const XML_PATH_ENHANCED_LINK_ATTRIBUTION = 'google/analyticsplus_universal/enhanced_link_attribution';
    const XML_PATH_UNIVERSAL_DEBUG = 'google/analyticsplus_universal/debug';

    /**
     * Config enabling IP Anonymisation
     *
     * @return bool
     */
    public function isAnonymiseEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_UNIVERSAL_ANONYMISE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Config enabling Display Advertising
     *
     * @return bool
     */
    public function isDisplayAdvertisingEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_UNIVERSAL_DISPLAY_ADS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Config enabling Enhanced Link Attribution
     *
     * @return bool
     */
    public function isEnhancedLinkAttrEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENHANCED_LINK_ATTRIBUTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
