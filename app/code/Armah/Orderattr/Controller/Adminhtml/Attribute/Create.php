<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Attribute;

class Create extends \Armah\Orderattr\Controller\Adminhtml\Attribute
{
    /**
     * @see \Armah\Orderattr\Controller\Adminhtml\Attribute\Edit::execute
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
