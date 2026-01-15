<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api;

use Armah\Geoip\Api\Data\BlockInterface;
use Armah\Geoip\Api\Data\IpLogInterface;

interface BlockRepositoryInterface
{
    /**
     * @param IpLogInterface[] $ipLogs
     * @return BlockInterface[]
     */
    public function getByIpLogs(array $ipLogs): array;

    /**
     * @param BlockInterface[] $blocks
     * @return int
     */
    public function deleteByStartAndEndIpNum(array $blocks): int;

    /**
     * @param BlockInterface[] $blocks
     * @return int
     */
    public function insertMultiple(array $blocks): int;
}
