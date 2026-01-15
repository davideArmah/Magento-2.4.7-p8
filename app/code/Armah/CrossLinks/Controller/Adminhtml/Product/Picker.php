<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Controller\Adminhtml\Product;

class Picker extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Armah_CrossLinks::seo';

    /**
     * Chooser Source action
     *
     * @return void
     */
    public function execute()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');

        $productGrid = $this->_view->getLayout()->createBlock(
            \Armah\CrossLinks\Block\Adminhtml\Link\Edit\Form\Renderer\ProductPicker::class,
            '',
            ['data' => ['id' => $uniqId]]
        );
        $html = $productGrid->toHtml();

        $this->getResponse()->setBody($html);
    }
}
