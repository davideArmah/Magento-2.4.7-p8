<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\ResourceModel;

use Armah\Geoip\Api\Data\LocationInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Location extends AbstractDb
{
    public const TABLE_NAME = 'armah_geoip_location';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, LocationInterface::LOCATION_ID);
    }
}
