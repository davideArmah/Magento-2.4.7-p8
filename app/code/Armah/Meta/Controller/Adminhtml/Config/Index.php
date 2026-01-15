<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Controller\Adminhtml\Config;

class Index extends \Armah\Meta\Controller\Adminhtml\Config
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend($this->_title);
        $this->_setActiveMenu('cms/arseotoolkit/armeta');
        $block =  $this->_view->getLayout()->createBlock(
            \Armah\Meta\Block\Adminhtml\Config::class,
            '',
            [
                'data' =>
                    [
                        'is_custom' => $this->_isCustom,
                        'title' => $this->_title
                    ]
            ]
        );
        $this->_addContent($block);
        $this->_view->renderLayout();

        return $this->getResponse();
    }
}
