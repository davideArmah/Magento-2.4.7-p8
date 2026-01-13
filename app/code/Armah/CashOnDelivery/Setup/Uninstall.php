<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Setup;

use Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee;
use Armah\CashOnDelivery\Model\ResourceModel\PaymentFee;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->getConnection()
            ->dropTable($setup->getTable(PaymentFee::TABLE_NAME));
        $setup->getConnection()
            ->dropTable($setup->getTable(OrderPaymentFee::TABLE_NAME));
    }
}
