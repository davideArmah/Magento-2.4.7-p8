<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Attribute\Relation\Relation;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Armah\Orderattr\Model\Attribute\Relation\Relation::class,
            \Armah\Orderattr\Model\ResourceModel\Attribute\Relation\Relation::class
        );
    }
}
