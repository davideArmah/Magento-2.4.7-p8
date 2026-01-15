<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api;

use Armah\Geoip\Api\Data\LocationInterface;

interface LocationRepositoryInterface
{
    /**
     * @param LocationInterface[] $locations
     * @return int
     */
    public function deleteByLocId(array $locations): int;

    /**
     * @param LocationInterface[] $locations
     * @return int
     */
    public function insertMultiple(array $locations): int;
}
