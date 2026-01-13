<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Armah (https://www.armah.it)
 * @package Cron Schedule List for Magento 2 (System) 
 */

namespace Armah\CronScheduleList\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractSchedule extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Armah_CronScheduleList::schedule_list';
}
