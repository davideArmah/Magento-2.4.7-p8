<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Setup;

use Armah\Orderattr\Model\ResourceModel\Attribute\Attribute as AttributeResource;
use Armah\Orderattr\Model\ResourceModel\Attribute\Relation\Relation as RelationResource;
use Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails as RelationDetailsResource;
use Armah\Orderattr\Model\ResourceModel\Entity\Entity as EntityResource;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    private const TABLE_NAMES = [
        EntityResource::TABLE_NAME,
        AttributeResource::TABLE_NAME,
        RelationResource::TABLE_NAME,
        RelationDetailsResource::TABLE_NAME,
        AttributeResource::CUSTOMER_GROUP_TABLE_NAME,
        AttributeResource::STORE_TABLE_NAME,
        'armah_order_attribute_entity_int',
        'armah_order_attribute_entity_decimal',
        'armah_order_attribute_entity_datetime',
        'armah_order_attribute_entity_text',
        'armah_order_attribute_entity_varchar',
        AttributeResource::SHIPPING_METHODS_TABLE_NAME,
        AttributeResource::TOOLTIP_TABLE_NAME
    ];

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();

        foreach (self::TABLE_NAMES as $tableName) {
            $connection->dropTable($setup->getTable($tableName));
        }
    }
}
