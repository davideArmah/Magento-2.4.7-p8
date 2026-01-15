<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\InstanceHash\ResourceModel;

use Armah\Base\Api\Data\InstanceHashInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class InstanceHash extends AbstractDb
{
    public const TABLE_NAME = 'armah_base_instance_hash';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, InstanceHashInterface::ID);
    }
}
