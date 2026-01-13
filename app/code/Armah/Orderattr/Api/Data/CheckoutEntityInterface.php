<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api\Data;

interface CheckoutEntityInterface
{
    /**#@+
     * Values for parent_entity_type
     */
    public const ENTITY_TYPE_ORDER = 1;
    public const ENTITY_TYPE_QUOTE = 2;
    /**#@-*/

    /**#@+
     * Constants defined for keys of data array
     */
    public const ENTITY_ID = 'entity_id';
    public const PARENT_ID = 'parent_id';
    public const PARENT_ENTITY_TYPE = 'parent_entity_type';
    /**#@-*/

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     *
     * @return \Armah\Orderattr\Api\Data\CheckoutEntityInterface
     */
    public function setEntityId($entityId);

    /**
     * @return int
     */
    public function getParentId();

    /**
     * @param int $parentId
     *
     * @return \Armah\Orderattr\Api\Data\CheckoutEntityInterface
     */
    public function setParentId($parentId);

    /**
     * @return int
     */
    public function getParentEntityType();

    /**
     * @param int $parentEntityType
     *
     * @return \Armah\Orderattr\Api\Data\CheckoutEntityInterface
     */
    public function setParentEntityType($parentEntityType);
}
