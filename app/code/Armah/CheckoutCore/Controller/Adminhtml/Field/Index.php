<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */
namespace Armah\CheckoutCore\Controller\Adminhtml\Field;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Armah_CheckoutCore::checkout_settings_fields';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Registry
     */
    protected $coreRegistry;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Armah_CheckoutCore::checkout_settings_fields');
        $resultPage->addBreadcrumb(__('System'), __('System'));
        $resultPage->addBreadcrumb(__('One Step Checkout'), __('One Step Checkout'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Checkout Fields'));

        return $resultPage;
    }
}
