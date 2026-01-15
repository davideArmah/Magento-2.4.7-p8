<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Adminhtml\Attribute\Edit\Tab;

use Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\AbstractOptions;

class Options extends AbstractOptions
{
    protected function _prepareLayout()
    {
        $this->addChild('labels', 'Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\Labels');
        $this->addChild('tooltip', 'Armah\Orderattr\Block\Adminhtml\Attribute\Edit\Tab\Options\Tooltip');
        $this->addChild('options', 'Armah\Orderattr\Block\Adminhtml\Attribute\Edit\Tab\Options\Options');

        return $this;
    }
}
