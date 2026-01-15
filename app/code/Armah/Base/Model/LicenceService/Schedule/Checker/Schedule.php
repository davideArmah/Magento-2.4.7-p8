<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Schedule\Checker;

use Armah\Base\Model\LicenceService\Schedule\Data\ScheduleConfig;
use Armah\Base\Model\LicenceService\Schedule\Data\ScheduleConfigFactory;
use Armah\Base\Model\LicenceService\Schedule\ScheduleConfigRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Schedule implements SenderCheckerInterface
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var ScheduleConfigFactory
     */
    private $scheduleConfigFactory;

    /**
     * @var ScheduleConfigRepository
     */
    private $scheduleConfigRepository;

    public function __construct(
        DateTime $dateTime,
        ScheduleConfigFactory $scheduleConfigFactory,
        ScheduleConfigRepository $scheduleConfigRepository
    ) {
        $this->dateTime = $dateTime;
        $this->scheduleConfigFactory = $scheduleConfigFactory;
        $this->scheduleConfigRepository = $scheduleConfigRepository;
    }

    public function isNeedToSend(string $flag): bool
    {
        $currentTime = $this->dateTime->gmtTimestamp();
        try {
            $scheduleConfig = $this->scheduleConfigRepository->get($flag);
        } catch (\InvalidArgumentException $exception) {
            $scheduleConfig = $this->scheduleConfigFactory->create();
            $scheduleConfig->addData($this->getScheduleConfig());
            $scheduleConfig->setLastSendDate($currentTime);
            $this->scheduleConfigRepository->save($flag, $scheduleConfig);

            return true;
        }

        if (null === ($timeIntervals = $scheduleConfig->getTimeIntervals())) {
            $scheduleConfig->addData($this->getScheduleConfig());
            $scheduleConfig->setLastSendDate($currentTime);
            $this->scheduleConfigRepository->save($flag, $scheduleConfig);

            return true;
        }

        $firstTimeInterval = array_shift($timeIntervals);
        $isNeedToSend = $currentTime > $scheduleConfig->getLastSendDate() + $firstTimeInterval;
        if ($isNeedToSend) {
            $scheduleConfig->setTimeIntervals($timeIntervals);
            $this->scheduleConfigRepository->save($flag, $scheduleConfig);
        }

        return $isNeedToSend;
    }

    public function getScheduleConfig(): array
    {
        return [
            ScheduleConfig::TIME_INTERVALS => [300, 900, 3600, 86400],
            ScheduleConfig::LAST_SEND_DATE => $this->dateTime->gmtTimestamp()
        ];
    }
}
