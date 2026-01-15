<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Block\Adminhtml;

class Config extends \Magento\Backend\Block\Widget\Grid\Container
{
    public function _construct()
    {
        $isCustom = $this->getIsCustom();
        $title = $this->getTitle();
        $this->_controller      = isset($isCustom) && $isCustom === true
            ? 'adminhtml_custom' : 'adminhtml_config';
        $this->_blockGroup      = 'Armah\Meta';

        $this->_headerText      = __($title);
        $this->_addButtonLabel = __('Add New');
        
        parent::_construct();
    }
}
