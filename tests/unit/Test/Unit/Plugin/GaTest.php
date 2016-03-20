<?php
namespace Fooman\GoogleAnalyticsPlus\Test\Unit\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class GaTest extends \PHPUnit_Framework_TestCase
{
    const TEST_ACCT_ID = 'UA-123456';
    const TEST_PAGE_URL = '/cms/index';

    protected $gaMock;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
    }

    public function testAroundGetPageTrackingCodeIncludesCreateTracker()
    {
        $actualResult = $this->executeAroundGetPageTracking();
        $this->assertEquals(sprintf("ga('create', '%s', 'auto');", self::TEST_ACCT_ID), $actualResult[0]);
    }

    public function testAroundGetPageTrackingCodeIncludesSetPageName()
    {
        $actualResult = $this->executeAroundGetPageTracking();
        $this->assertEquals("ga('set', 'page', '/cms');", trim($actualResult[1]));
    }

    public function testAroundGetPageTrackingCodeDoesntSendPageView()
    {
        $actualResult = $this->executeAroundGetPageTracking(true);
        $this->assertFalse(array_search("ga('send', 'pageview');", $actualResult));
    }

    public function testAroundGetPageTrackingCodeIncludesSendPageView()
    {
        $actualResult = $this->executeAroundGetPageTracking();
        $this->assertEquals("ga('send', 'pageview');", trim($actualResult[2]));
    }

    /**
     * @param $withOrderIds
     */
    private function prepareSubjectMock($withOrderIds)
    {
        $this->gaMock = $this->getMock(
            '\Magento\GoogleAnalytics\Block\Ga',
            ['escapeJsQuote', 'getPageName', 'getOrderIds'],
            [],
            '',
            false
        );
        if ($withOrderIds) {
            $this->gaMock->expects($this->any())->method('getOrderIds')->will($this->returnValue(['1']));
        }
        $this->gaMock->expects($this->any())->method('escapeJsQuote')->will($this->returnArgument(0));
        $this->gaMock->expects($this->any())->method('getPageName')->will($this->returnValue(self::TEST_PAGE_URL));
    }

    /**
     * @param bool|false $withOrderIds
     *
     * @return array
     */
    private function executeAroundGetPageTracking($withOrderIds = false)
    {
        $this->prepareSubjectMock($withOrderIds);

        /** @var $helper \Fooman\GoogleAnalyticsPlus\Helper\Url */
        $helper = $this->objectManager->getObject(
            'Fooman\GoogleAnalyticsPlus\Helper\Url'
        );

        /** @var $plugin \Fooman\GoogleAnalyticsPlus\Plugin\Ga */
        $plugin = $this->objectManager->getObject(
            'Fooman\GoogleAnalyticsPlus\Plugin\Ga',
            ['urlHelper' => $helper]
        );

        $closure = function () {
            return 'Test';
        };

        $actualResult = explode("\n", $plugin->aroundGetPageTrackingCode($this->gaMock, $closure, self::TEST_ACCT_ID));
        return $actualResult;
    }
}
