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

use Magento\Catalog\Api\ProductRepositoryInterface;
use Fooman\PhpunitBridge\AbstractBackendController;

class GaTest extends AbstractBackendController
{
    const GA_MARKER_START = '<!-- BEGIN GOOGLE ANALYTICS CODE -->';
    const GA_MARKER_END = '<!-- END GOOGLE ANALYTICS CODE -->';

    /** @var ProductRepositoryInterface */
    private $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository =  Bootstrap::getObjectManager()->get(ProductRepositoryInterface::class);
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testOnlyOneTrackerUsed()
    {
        $this->dispatch('');
        self::assertEquals(
            1,
            substr_count($this->getGaScriptFromPage(), "Magento_GoogleAnalytics/js/google-analytics")
        );
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnHomepage()
    {
        $this->dispatch('');
        self::assertStringContainsString('"optPageUrl":""', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnHomepageWithSlash()
    {
        $this->dispatch('/');
        self::assertStringContainsString('"optPageUrl":""', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameWithQuery()
    {
        $this->dispatch('/?param1=key1&param2');
        self::assertStringContainsString('"optPageUrl":""', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageOnCmsIndexIndexNameWithQuery()
    {
        $this->dispatch('/cms/index/index?param1=key1&param2');
        self::assertStringContainsString(
            '"optPageUrl":"\/cms"',
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
        self::assertStringContainsString('"optPageUrl":"\/cms"', $this->getGaScriptFromPage());
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
        self::assertStringContainsString('"isDisplayFeaturesActive":1', $this->getGaScriptFromPage());
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
        self::assertStringContainsString('"isDisplayFeaturesActive":0', $this->getGaScriptFromPage());
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
        self::assertStringContainsString('"isEnhancedLinksActive":1', $this->getGaScriptFromPage());
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
        self::assertStringContainsString('"isEnhancedLinksActive":0', $this->getGaScriptFromPage());
    }

    /**
     * @magentoAppArea       frontend
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnProductPage()
    {
        $product = $this->productRepository->get('simple');
        $internalUrl = sprintf('catalog/product/view/id/%s', $product->getEntityId());
        $this->dispatch($internalUrl);
        self::assertStringContainsString(
            '"optPageUrl":"\/catalog\/product\/view\/id"',
            $this->getGaScriptFromPage()
        );
    }

    /**
     * @magentoAppArea       frontend
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnRewrittenProductPage()
    {
        $product = $this->productRepository->get('simple');
        $this->dispatch($product->getUrlKey());
        self::assertStringContainsString(
            '"optPageUrl":"\/catalog\/product\/view\/id"',
            $this->getGaScriptFromPage()
        );
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
