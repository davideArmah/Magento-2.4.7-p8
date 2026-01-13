<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Armah (https://www.armah.it)
 * @package Cron Schedule List for Magento 2 (System) 
 */

namespace Armah\CronScheduleList\Controller\Adminhtml\Schedule;

use Armah\CronScheduleList\Controller\Adminhtml\AbstractSchedule;
use Magento\Framework\Controller\ResultFactory;

class Index extends AbstractSchedule
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
        $resultPage->setActiveMenu('Armah_CronScheduleList::schedule_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Cron Tasks List'));
        $resultPage->addBreadcrumb(__('Cron Tasks List'), __('Cron Tasks List'));

        return $resultPage;
    }
}
