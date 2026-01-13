<?php
namespace Armah\Meta\Block\Adminhtml\Custom\Edit;
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('customTabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Template Configuration'));
    }

    protected function _beforeToHtml()
    {
        $name = __('General');
        $this->addTab('general', array(
                'label'   => $name,
                'content' => $this->getLayout()->createBlock('Armah\Meta\Block\Adminhtml\Custom\Edit\Tab\General')
                        ->setTitle($name)->toHtml(),
            )
        );

        $name = __('Page Content');
        $this->addTab('content', array(
                'label'   => $name,
                'content' => $this->getLayout()->createBlock('Armah\Meta\Block\Adminhtml\Custom\Edit\Tab\Content')
                        ->setTitle($name)->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }
}