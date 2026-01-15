<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api;

use Armah\Geoip\Api\Data\BlockV6Interface;
use Armah\Geoip\Api\Data\IpLogInterface;

interface BlockV6RepositoryInterface
{
    /**
     * @param IpLogInterface[] $ipLog
     * @return BlockV6Interface[]
     */
    public function getByIpLogs(array $ipLogs): array;

    /**
     * @param BlockV6Interface[] $blocks
     * @return int
     */
    public function deleteByStartAndEndIpNum(array $blocks): int;

    /**
     * @param BlockV6Interface[] $blocks
     * @return int
     */
    public function insertMultiple(array $blocks): int;
}
