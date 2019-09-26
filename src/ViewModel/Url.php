<?php
/**
 * @author     Kristof Ringleff
 * @package    Fooman_GoogleAnalyticsPlus
 * @copyright  Copyright (c) 2015 Fooman Limited (http://www.fooman.co.nz)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fooman\GoogleAnalyticsPlus\ViewModel;

class Url implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $urlHelper;

    /**
     * Url constructor.
     *
     * @param \Fooman\GoogleAnalyticsPlus\Helper\Url $urlHelper
     */
    public function __construct(
        \Fooman\GoogleAnalyticsPlus\Helper\Url $urlHelper
    ) {
        $this->urlHelper = $urlHelper;
    }

    public function getUnifiedUrlParts()
    {
        return $this->urlHelper->getUnifiedUrlParts();
    }
}
