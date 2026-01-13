<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Controller\Adminhtml\Custom;

class Index extends \Armah\Meta\Controller\Adminhtml\Config\Index
{
    /**
     * @var string
     */
    protected $_title = 'Meta Tags Template (URLs)';
    /**
     * @var bool
     */
    protected $_isCustom = true;

    public function execute()
    {
        $this->_blockName = 'custom';
        $result =  parent::execute();

        return $result;
    }
}
