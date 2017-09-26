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

class GaTest extends \Magento\TestFramework\TestCase\AbstractController
{
    const GA_MARKER_START = '<!-- BEGIN GOOGLE ANALYTICS CODE -->';
    const GA_MARKER_END = '<!-- END GOOGLE ANALYTICS CODE -->';


    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testOnlyOneTrackerUsed()
    {
        $this->dispatch('');
        $this->assertEquals(1, substr_count($this->getGaScriptFromPage(), "Magento_GoogleAnalytics/js/google-analytics"));
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnHomepage()
    {
        $this->dispatch('');
        $this->assertContains('"optPageUrl":""', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnHomepageWithSlash()
    {
        $this->dispatch('/');
        $this->assertContains('"optPageUrl":""', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameWithQuery()
    {
        $this->dispatch('/?param1=key1&param2');
        $this->assertContains('"optPageUrl":"?param1=key1&param2"', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageOnCmsIndexIndexNameWithQuery()
    {
        $this->dispatch('/cms/index/index?param1=key1&param2');
        $this->assertContains(
            '"optPageUrl":"\/cms?param1=key1&param2\')"',
            $this->getGaScriptFromPage()
        );
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnCmsIndexIndex()
    {
        $this->dispatch('/cms/index/index');
        $this->assertContains('"optPageUrl":"\/cms"', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     * @magentoConfigFixture current_store google/analyticsplus_universal/display_advertising 1
     */
    public function testDisplayAdvertising()
    {
        $this->dispatch('');
        $this->assertContains('"isDisplayFeaturesActive":1', $this->getGaScriptFromPage());
    }


    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     * @magentoConfigFixture current_store google/analyticsplus_universal/display_advertising 0
     */
    public function testDontDisplayAdvertising()
    {
        $this->dispatch('');
        $this->assertContains('"isDisplayFeaturesActive":0', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     * @magentoConfigFixture current_store google/analyticsplus_universal/enhanced_link_attribution 1
     */
    public function testEnhancedLinkAttribution()
    {
        $this->dispatch('');
        $this->assertContains('"isEnhancedLinksActive":1', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     * @magentoConfigFixture current_store google/analyticsplus_universal/enhanced_link_attribution 0
     */
    public function testNoEnhancedLinkAttribution()
    {
        $this->dispatch('');
        $this->assertContains('"isEnhancedLinksActive":0', $this->getGaScriptFromPage());
    }

    /**
     * extract GA script from full page response
     *
     * @return string
     */
    private function getGaScriptFromPage()
    {
        $body = $this->getResponse()->getBody();
        $start = strpos($body, self::GA_MARKER_START);
        $end = strpos($body, self::GA_MARKER_END) + strlen(self::GA_MARKER_END);
        return PHP_EOL . substr($body, $start, $end - $start) . PHP_EOL;
    }
}
