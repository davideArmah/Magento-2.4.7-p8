<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Armah (https://www.armah.it)
 * @package Cron Schedule List for Magento 2 (System) 
 */

namespace Armah\CronScheduleList\Cron;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Module\Manager;

class Activity
{
    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function execute()
    {
        $moduleManager = $this->moduleManager;

        if ($moduleManager->isEnabled('Armah_CronScheduler')) {
            /** @var \Armah\CronScheduler\Model\JobsGenerator $jobsGenerator */
            $jobsGenerator = ObjectManager::getInstance()->get(\Armah\CronScheduler\Model\JobsGenerator::class);
            $jobsGenerator->execute();

            /** @var @var \Armah\CronScheduler\Model\FailedJobsNotifier $emailNotifier */
            $emailNotifier = ObjectManager::getInstance()->get(\Armah\CronScheduler\Model\FailedJobsNotifier::class);
            $emailNotifier->updateFailedJobs();
        }
    }
}
