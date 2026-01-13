<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Setup;

use Armah\CheckoutCore\Model\ResourceModel\AdditionalFields;
use Armah\CheckoutCore\Model\ResourceModel\Fee;
use Armah\CheckoutCore\Model\ResourceModel\Field;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields;
use Armah\CheckoutCore\Model\ResourceModel\QuotePasswords;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @param SchemaSetupInterface $installer
     * @param ModuleContextInterface $context
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(SchemaSetupInterface $installer, ModuleContextInterface $context)
    {
        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable(Field::MAIN_TABLE));
        $installer->getConnection()->dropTable($installer->getTable(Fee::MAIN_TABLE));
        $installer->getConnection()->dropTable($installer->getTable(AdditionalFields::MAIN_TABLE));
        $installer->getConnection()->dropTable($installer->getTable(QuoteCustomFields::MAIN_TABLE));
        $installer->getConnection()->dropTable($installer->getTable(OrderCustomFields::MAIN_TABLE));
        $installer->getConnection()->dropTable($installer->getTable(QuotePasswords::MAIN_TABLE));

        $installer->endSetup();
    }
}
