<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Block\Adminhtml;

/**
 * Class Link
 * @package Armah\CrossLinks\Block\Adminhtml
 */
class Link extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Armah_CrossLinks';
        $this->_controller = 'adminhtml_link';
        $this->_headerText = __('Cross Links Management');
        $this->_addButtonLabel = __('Add New Link');
        parent::_construct();
    }
}
