<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\ResourceModel\IpLog;

use Armah\Geoip\Model\IpLog;
use Armah\Geoip\Model\ResourceModel\IpLog as IpLogResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(IpLog::class, IpLogResource::class);
    }
}
