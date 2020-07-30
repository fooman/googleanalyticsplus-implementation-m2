<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\GoogleAnalyticsPlus\Block;

use Fooman\PhpunitBridge\AbstractBackendController;

class JsTest extends AbstractBackendController
{
    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageNameOnHomepage()
    {
        $this->dispatch('');
        $body = $this->getResponse()->getBody();
        self::assertStringContainsString("var foomanGaBaseUrl = '';", $body);
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testGetPageOnCmsIndexIndexNameWithQuery()
    {
        $this->dispatch('/cms/index/index?param1=key1&param2');
        $body = $this->getResponse()->getBody();
        self::assertStringContainsString("var foomanGaBaseUrl = '/cms';", $body);
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testJsQueryParams()
    {
        $this->dispatch('/index?</script><script>confirm(document.cookie)</script>');
        $body = $this->getResponse()->getBody();
        self::assertNotContains("<script>confirm(document.cookie)</script>", $body);
    }

    /**
     * @magentoAppArea       frontend
     * @magentoConfigFixture current_store google/analytics/active 1
     * @magentoConfigFixture current_store google/analytics/account UA-123
     */
    public function testBaseUrlXss()
    {
        $this->dispatch('/index/</script><script>confirm(document.cookie)</script>');
        $body = $this->getResponse()->getBody();
        self::assertNotContains("<script>confirm(document.cookie)</script>", $body);
    }
}
