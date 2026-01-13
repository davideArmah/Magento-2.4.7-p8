<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Controller\Adminhtml;

abstract class Custom extends \Armah\Meta\Controller\Adminhtml\Config
{
    /**
     * @var string
     */
    protected $_title = 'Meta Tags Template (Custom URLs)';

    /**
     * @var bool
     */
    protected $_isCustom = true;

    /**
     * @var string
     */
    protected $_blockName = 'custom';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Armah_Meta::custom');
    }
}
