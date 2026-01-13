<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Controller\Adminhtml\Link;

/**
 * Class Index
 * @package Armah\CrossLinks\Controller\Adminhtml\Link
 */
class Index extends \Armah\CrossLinks\Controller\Adminhtml\Link
{
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Armah_CrossLinks::seo')
            ->addBreadcrumb(__('Cross Link Management'), __('Cross Link Management'));
        $resultPage->getConfig()->getTitle()->prepend(__('Cross Link Management'));
        return $resultPage;
    }
}
