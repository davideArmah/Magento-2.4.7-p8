<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Attribute;

use Armah\Orderattr\Api\Data\CheckoutAttributeInterface;
use Armah\Orderattr\Model\Config\Source\CheckoutStep;
use Armah\Orderattr\Model\Indexer\Conditions\AbstractIndexer;
use Armah\Orderattr\Model\ResourceModel\Attribute\Attribute as AttributeResource;
use Armah\Orderattr\Model\ResourceModel\Entity\Entity;

/**
 * @method \Armah\Orderattr\Model\Attribute\Attribute[] getItems()
 */
class Collection extends \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
{
    /**
     * Resource model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Armah\Orderattr\Model\Attribute\Attribute::class,
            AttributeResource::class
        );
    }

    /**
     * Initialize select object
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $entityType = $this->eavConfig->getEntityType(Entity::ENTITY_TYPE_CODE);
        $this->setEntityTypeFilter($entityType);
        return $this;
    }

    /**
     * Specify "is_filterable" filter
     *
     * @return $this
     */
    public function addGridFilter()
    {
        return $this->addFieldToFilter('additional_table.is_filterable', ['gt' => 0]);
    }

    /**
     * Specify "checkout_step" filter.
     * It's needed to consider existed order attributes to show them in the storefront order page.
     */
    public function addFilterUnassignedOnCheckout(array $attrCodes = []): void
    {
        $this->addFieldToFilter(
            'additional_table.' . CheckoutAttributeInterface::CHECKOUT_STEP,
            ['neq' => CheckoutStep::NONE]
        )->getSelect()->orWhere(
            'main_table.' . CheckoutAttributeInterface::ATTRIBUTE_CODE . ' IN (?)',
            $attrCodes
        );
    }

    /**
     * Specify "is_filterable" filter
     *
     * @return $this
     */
    public function addIsFilterableFilter()
    {
        return $this->addFieldToFilter('additional_table.' . CheckoutAttributeInterface::SHOW_ON_GRIDS, ['gt' => 0]);
    }

    /**
     * Add store filter
     *
     * @param int|array $storeId
     * @return $this
     */
    public function addStoreFilter($storeId)
    {
        if (!is_array($storeId)) {
            $storeId = [$storeId];
        }

        $this->join(
            AttributeResource::STORE_TABLE_NAME,
            AttributeResource::STORE_TABLE_NAME . '.' . CheckoutAttributeInterface::ATTRIBUTE_ID
            . '= main_table.' . CheckoutAttributeInterface::ATTRIBUTE_ID
            . ' AND '
            . $this->getConnection()->quoteInto(AttributeResource::STORE_TABLE_NAME . '.store_id IN(?)', $storeId),
            null
        );

        $this->distinct(true);

        return $this;
    }

    public function addStoresFilter(array $storeIds): self
    {
        return $this->addStoreFilter($storeIds);
    }

    /**
     * Add customer group filter
     *
     * @param int $groupId
     * @return $this
     */
    public function addCustomerGroupFilter($groupId)
    {
        $this->join(
            AttributeResource::CUSTOMER_GROUP_TABLE_NAME,
            AttributeResource::CUSTOMER_GROUP_TABLE_NAME . '.' . CheckoutAttributeInterface::ATTRIBUTE_ID
            . '= main_table.' . CheckoutAttributeInterface::ATTRIBUTE_ID
            . ' AND ' . AttributeResource::CUSTOMER_GROUP_TABLE_NAME . '.customer_group_id =' . (int)$groupId,
            null
        );

        return $this;
    }

    /**
     * Add shipping method filter
     *
     * @param string $shippingMethod
     * @return $this
     */
    public function addShippingMethodsFilter($shippingMethod)
    {
        $this->joinLeft(
            AttributeResource::SHIPPING_METHODS_TABLE_NAME,
            'main_table.' . CheckoutAttributeInterface::ATTRIBUTE_ID . '='
                . AttributeResource::SHIPPING_METHODS_TABLE_NAME . '.' . CheckoutAttributeInterface::ATTRIBUTE_ID,
            null
        )->addFieldToFilter(
            AttributeResource::SHIPPING_METHODS_TABLE_NAME . '.shipping_method',
            [
                ['null' => true],
                ['eq' => $shippingMethod]
            ]
        );

        return $this;
    }

    /**
     * Set order by attribute sort order
     *
     * @param string $direction
     * @return $this
     */
    public function setSortOrder($direction = self::SORT_ORDER_ASC)
    {
        return $this->setOrder(
            'additional_table.' . \Armah\Orderattr\Api\Data\CheckoutAttributeInterface::SORTING_ORDER,
            $direction
        );
    }

    /**
     * @param string[] $productIds
     */
    public function addConditionsFilter(array $productIds): void
    {
        $this->joinLeft(
            AbstractIndexer::MAIN_TABLE,
            'main_table.' . CheckoutAttributeInterface::ATTRIBUTE_ID . '='
            . AbstractIndexer::MAIN_TABLE . '.' . AbstractIndexer::ATTRIBUTE_ID,
            null
        )->getSelect()->where(
            AbstractIndexer::MAIN_TABLE . '.' . AbstractIndexer::PRODUCT_ID . ' IN(?)
                OR ISNULL(additional_table.' . CheckoutAttributeInterface::CONDITIONS_SERIALIZED . ')',
            $productIds
        );
        $this->addAttributeGrouping();
    }
}
