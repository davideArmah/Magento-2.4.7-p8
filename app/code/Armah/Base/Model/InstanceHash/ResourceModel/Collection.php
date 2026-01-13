<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\InstanceHash\ResourceModel;

use Armah\Base\Model\InstanceHash\InstanceHash as InstanceHashModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(InstanceHashModel::class, InstanceHash::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
