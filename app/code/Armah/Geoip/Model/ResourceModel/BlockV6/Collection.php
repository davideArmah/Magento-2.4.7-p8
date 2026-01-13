<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\ResourceModel\BlockV6;

use Armah\Geoip\Api\Data\BlockV6Interface;
use Armah\Geoip\Model\BlockV6;
use Armah\Geoip\Model\ResourceModel\BlockV6 as BlockV6Resource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BlockV6::class, BlockV6Resource::class);
    }

    public function addFilterByLongIp(string $longIp): void
    {
        $condition = sprintf(
            '%s <= ? AND %s >= ?',
            BlockV6Interface::START_IP_NUM,
            BlockV6Interface::END_IP_NUM
        );

        $where = $this->getConnection()->quoteInto($condition, $longIp);
        $this->getSelect()
            ->oRwhere($where);
    }
}
