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

use Magento\Framework\App\Helper\Context;

class Url extends \Magento\Framework\App\Helper\AbstractHelper
{
    private $config;

    public function __construct(
        Context $context,
        Config $config
    ) {
        $this->config = $config;
        parent::__construct($context);
    }

    /**
     * Magento default analytics reports can include the same page as
     * /contact/index/index/ and  /contact/index/
     * filter out any index/ here and unify to no trailing /
     *
     * @param string $customPageName
     *
     * @return string
     */
    public function getUnifiedPageName($customPageName = '')
    {
        if (!$customPageName) {
            return '';
        }

        $pageName = trim($customPageName);

        if (empty($pageName)) {
            if ($this->config->usePathInfo()) {
                $pageName = $this->_getRequest()->getPathInfo();
            } else {
                $pageName = $this->_getRequest()->getRequestUri();
            }
        }

        return rtrim(str_replace(['/index', '/?'], ['', '?'], $pageName), '/');
    }

    public function getUnifiedUrlParts()
    {
        return ['path' => $this->getUnifiedPageName()];
    }
}
