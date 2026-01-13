<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Schedule;

use Armah\Base\Model\FlagRepository;
use Armah\Base\Model\LicenceService\Schedule\Data\ScheduleConfig;
use Armah\Base\Model\LicenceService\Schedule\Data\ScheduleConfigFactory;
use Armah\Base\Model\Schedule\Repository;
use Armah\Base\Model\Schedule\ScheduleFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;

class ScheduleConfigRepository
{
    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var ScheduleConfigFactory
     */
    private $scheduleConfigFactory;

    /**
     * @var Repository
     */
    private $scheduleRepository;

    /**
     * @var ScheduleFactory
     */
    private $scheduleFactory;

    public function __construct(
        FlagRepository $flagRepository, //@deprecated
        SerializerInterface $serializer, //@deprecated
        DataObjectHelper $dataObjectHelper,
        ScheduleConfigFactory $scheduleConfigFactory,
        ?Repository $scheduleRepository = null,
        ?ScheduleFactory $scheduleFactory = null
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->scheduleConfigFactory = $scheduleConfigFactory;
        $this->scheduleRepository = $scheduleRepository ?? ObjectManager::getInstance()->get(Repository::class);
        $this->scheduleFactory = $scheduleFactory ?? ObjectManager::getInstance()->get(ScheduleFactory::class);
    }

    public function get(string $flag): ScheduleConfig
    {
        try {
            $schedule = $this->scheduleRepository->get($flag);
            $scheduleConfigArray = $schedule->toArray();
            $scheduleConfigArray[ScheduleConfig::TIME_INTERVALS] = array_filter(
                explode(',', (string)$schedule->getTimeIntervals())
            );
            $scheduleConfigArray[ScheduleConfig::LAST_SEND_DATE] = $schedule->getLastSendDate();
        } catch (NoSuchEntityException $e) {
            $scheduleConfigArray = [];
        }
        $scheduleConfigInstance = $this->scheduleConfigFactory->create();
        if (!empty($scheduleConfigArray)) {
            $this->dataObjectHelper->populateWithArray(
                $scheduleConfigInstance,
                $scheduleConfigArray,
                ScheduleConfig::class
            );
        }

        return $scheduleConfigInstance;
    }

    public function save(string $flag, ScheduleConfig $scheduleConfig): bool
    {
        $schedule = $this->scheduleFactory->create();
        $schedule->setCode($flag);
        $schedule->setTimeIntervals(implode(',', (array)$scheduleConfig->getTimeIntervals()) ?: null);
        $schedule->setLastSendDate((int)$scheduleConfig->getLastSendDate());
        $this->scheduleRepository->save($schedule);

        return true;
    }
}
