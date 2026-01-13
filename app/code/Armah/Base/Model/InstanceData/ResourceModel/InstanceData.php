<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\InstanceData\ResourceModel;

use Armah\Base\Api\Data\InstanceDataInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class InstanceData extends AbstractDb
{
    public const TABLE_NAME = 'armah_base_instance_data';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, InstanceDataInterface::ID);
    }
}
