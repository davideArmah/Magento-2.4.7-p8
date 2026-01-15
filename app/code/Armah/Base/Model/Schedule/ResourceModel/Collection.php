<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Schedule\ResourceModel;

use Armah\Base\Model\Schedule\Schedule as ScheduleModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(ScheduleModel::class, Schedule::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
