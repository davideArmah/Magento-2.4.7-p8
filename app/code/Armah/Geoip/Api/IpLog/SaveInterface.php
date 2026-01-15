<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api\IpLog;

use Armah\Geoip\Api\Data\IpLogInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface SaveInterface
{
    /**
     * @param IpLogInterface $ipLog
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(IpLogInterface $ipLog): void;

    /**
     * @param IpLogInterface[] $ipLogs
     * @return void
     * @throws CouldNotSaveException
     */
    public function executeMultiple(array $ipLogs): void;
}
