<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Schedule\ResourceModel;

use Armah\Base\Api\Data\ScheduleInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Schedule extends AbstractDb
{
    public const TABLE_NAME = 'armah_base_schedule';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, ScheduleInterface::ID);
    }
}
