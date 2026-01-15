<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Entity\EntityData;

/**
 * @method \Armah\Orderattr\Model\ResourceModel\Entity\Entity getResource()
 */
class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            \Armah\Orderattr\Model\Entity\EntityData::class,
            \Armah\Orderattr\Model\ResourceModel\Entity\Entity::class
        );
    }
}
