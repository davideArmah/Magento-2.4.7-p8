<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Relation;

class NewAction extends \Armah\Orderattr\Controller\Adminhtml\Relation
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
