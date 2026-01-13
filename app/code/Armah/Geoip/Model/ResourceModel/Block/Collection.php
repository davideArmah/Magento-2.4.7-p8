<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\ResourceModel\Block;

use Armah\Geoip\Api\Data\BlockInterface;
use Armah\Geoip\Model\Block;
use Armah\Geoip\Model\ResourceModel\Block as BlockResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Block::class, BlockResource::class);
    }

    public function addFilterByLongIp(string $longIp): void
    {
        $condition = sprintf(
            '%s <= ? AND %s >= ?',
            BlockInterface::START_IP_NUM,
            BlockInterface::END_IP_NUM
        );

        $where = $this->getConnection()->quoteInto($condition, $longIp);
        $this->getSelect()
            ->oRwhere($where);
    }
}
