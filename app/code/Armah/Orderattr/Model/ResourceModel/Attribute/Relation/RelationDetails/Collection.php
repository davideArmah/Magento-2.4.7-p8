<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails;

use Armah\Orderattr\Api\Data\RelationDetailInterface;
use Armah\Orderattr\Block\Checkout\LayoutProcessor;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @method \Armah\Orderattr\Api\Data\RelationDetailInterface[] getItems()
 */
class Collection extends AbstractCollection
{

    /**
     * @param $relationId
     * @return $this
     */
    public function getByRelation($relationId)
    {
        $this->addFieldToFilter(RelationDetailInterface::RELATION_ID, $relationId);
        return $this;
    }

    protected function _construct()
    {
        $this->_init(
            \Armah\Orderattr\Model\Attribute\Relation\RelationDetails::class,
            \Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails::class
        );
    }

    /**
     * join EAV attribute codes
     *
     * @return $this
     */
    public function joinDependAttributeCode()
    {
        $this->getSelect()->joinInner(
            ['dependent' => $this->getTable('eav_attribute')],
            'main_table.' . \Armah\Orderattr\Api\Data\RelationDetailInterface::DEPENDENT_ATTRIBUTE_ID
            . ' = dependent.attribute_id',
            ['dependent.attribute_code as dependent_attribute_code']
        )->joinInner(
            ['parent' => $this->getTable('eav_attribute')],
            'main_table.attribute_id = parent.attribute_id',
            ['parent.attribute_code as parent_attribute_code']
        );

        return $this;
    }

    /**
     * Prepare relations for attribute
     *
     * @param int $attributeId
     *
     * @return array
     */
    public function getAttributeRelations($attributeId)
    {
        return $this->addFieldToFilter('main_table.attribute_id', $attributeId)
            ->joinDependAttributeCode()
            ->toRelationArray();
    }

    /**
     * return array with keys:
     *   [attribute_name] - element name of parent attribute
     *   [dependent_name] - element name of depend attribute
     *   [option_value]   - value which Parent should have to show Depend
     *
     * @return array
     */
    public function toRelationArray()
    {
        $relations = [];
        /** @var \Armah\Orderattr\Api\Data\RelationDetailInterface $relation */
        foreach ($this->getItems() as $relation) {
            $relations[] = [
                'option_value'   => $relation->getOptionId(),
                'attribute_name' => $relation->getData('parent_attribute_code'),
                'dependent_name' => $relation->getData('dependent_attribute_code')
            ];
        }
        return $relations;
    }
}
