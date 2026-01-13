<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template;

/**
 * Block Extender For Expand Sections
 */
class Expander extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Armah_CheckoutCore::system/config/form/expander.phtml';

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->getRequest()->getParam('section');
    }

    /**
     * @return string
     */
    public function getExpand()
    {
        return $this->getRequest()->getParam('expand');
    }
}
