<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Attribute\Relation;

use Armah\Orderattr\Api\Data\RelationInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Relation extends AbstractDb
{
    public const TABLE_NAME = 'armah_order_attribute_relation';

    /**
     * @var RelationDetails\CollectionFactory
     */
    private $detailFactory;

    /**
     * @var RelationDetails
     */
    private $detailResource;

    /**
     * Relation constructor.
     * @param Context $context
     * @param RelationDetails\CollectionFactory $detailFactory
     * @param RelationDetails $detailResource
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        \Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails\CollectionFactory $detailFactory,
        \Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails $detailResource,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->detailFactory = $detailFactory;
        $this->detailResource = $detailResource;
    }

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(self::TABLE_NAME, RelationInterface::RELATION_ID);
    }

    /**
     * @param $relationId
     * @return \Armah\Orderattr\Api\Data\RelationDetailInterface[]
     */
    public function getDetails($relationId)
    {
        /** @var RelationDetails\Collection $detailsCollection */
        $detailsCollection = $this->detailFactory->create();
        $detailsCollection->getByRelation($relationId);

        return $detailsCollection->getItems();
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     *
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->hasData('relation_details')) {
            $this->detailResource->deleteAllDetailForRelation($object->getRelationId());
            foreach ($object->getDetails() as $detail) {
                $detail->setRelationId($object->getRelationId());
                $this->detailResource->save($detail);
            }
        }

        return parent::_afterSave($object);
    }
}
