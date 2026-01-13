<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\IpLog\Repository;

use Armah\Geoip\Api\IpLog\DeleteInterface;
use Armah\Geoip\Model\ResourceModel\IpLog as IpLogResource;

class Delete implements DeleteInterface
{
    /**
     * @var IpLogResource
     */
    private $ipLogResource;

    public function __construct(
        IpLogResource $ipLogResource
    ) {
        $this->ipLogResource = $ipLogResource;
    }

    public function deleteByLastVisitOlderThan(string $date): int
    {
        return $this->ipLogResource->deleteByLastVisitOlderThan($date);
    }
}
