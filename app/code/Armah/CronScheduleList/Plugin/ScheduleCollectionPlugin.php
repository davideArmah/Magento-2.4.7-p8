<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Armah (https://www.armah.it)
 * @package Cron Schedule List for Magento 2 (System) 
 */

namespace Armah\CronScheduleList\Plugin;

class ScheduleCollectionPlugin
{
    public function afterGetIdFieldName($subject, $result)
    {
        if ($result === null) {
            $result = 'schedule_id';
        }

        return $result;
    }
}
