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

class Url extends \Magento\Framework\App\Helper\AbstractHelper
{
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
        $pageName = trim($customPageName);

        if (empty($pageName)) {
            $pageName = $this->_getRequest()->getPathInfo();
        }

        return rtrim(str_replace(['/index', '/?'], ['', '?'], $pageName), '/');
    }

    public function getUnifiedUrlParts()
    {
        return ['path' => $this->getUnifiedPageName()];
    }
}
