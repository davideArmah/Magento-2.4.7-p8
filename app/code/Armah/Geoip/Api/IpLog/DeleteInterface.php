<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api\IpLog;

interface DeleteInterface
{
    /**
     * @param string $date
     * @return int
     */
    public function deleteByLastVisitOlderThan(string $date): int;
}
