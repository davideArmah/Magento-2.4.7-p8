<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\InstanceData\ResourceModel;

use Armah\Base\Model\InstanceData\InstanceData as InstanceDataModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(InstanceDataModel::class, InstanceData::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
