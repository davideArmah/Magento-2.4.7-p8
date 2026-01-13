<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\ResourceModel;

use Armah\Geoip\Api\Data\BlockV6Interface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BlockV6 extends AbstractDb
{
    public const TABLE_NAME = 'armah_geoip_block_v6';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, BlockV6Interface::BLOCK_ID);
    }
}
