<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Block\Adminhtml\Widget\Grid\Column\Renderer;
class Category
    extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    public function render(\Magento\Framework\DataObject $row)
    {
        return $row->getData('category_name');
    }
}
