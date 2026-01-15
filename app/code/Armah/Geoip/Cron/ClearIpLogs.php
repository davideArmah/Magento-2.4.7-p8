<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Cron;

use Armah\Geoip\Api\IpLog\DeleteInterface;
use Exception;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Psr\Log\LoggerInterface;

class ClearIpLogs
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var DeleteInterface
     */
    private $deleter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        DateTime $dateTime,
        DeleteInterface $deleter,
        LoggerInterface $logger
    ) {
        $this->dateTime = $dateTime;
        $this->deleter = $deleter;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $this->deleter->deleteByLastVisitOlderThan($this->dateTime->gmtDate('Y-m-d', '-1 month'));
        } catch (Exception $exception) {
            $this->logger->error($exception);
        }
    }
}
