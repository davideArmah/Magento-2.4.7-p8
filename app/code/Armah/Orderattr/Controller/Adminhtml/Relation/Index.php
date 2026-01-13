<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Relation;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Armah\Orderattr\Controller\Adminhtml\Relation
{
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Armah_Orderattr::attributes_relation');
        $resultPage->addBreadcrumb(__('Order Attribute'), __('Order Attribute'));
        $resultPage->addBreadcrumb(__('Attribute Relation'), __('Attribute Relation'));
        $resultPage->getConfig()->getTitle()->prepend(__('Order Attribute Relations'));

        return $resultPage;
    }
}
