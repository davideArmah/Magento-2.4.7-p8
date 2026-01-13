<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\Field;

use Magento\Backend\Block\Widget\Form\Container as FormContainer;

class Edit extends FormContainer
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_field';
        $this->_blockGroup = 'Armah_CheckoutCore';

        parent::_construct();

        $this->buttonList->remove('reset');
    }
}
