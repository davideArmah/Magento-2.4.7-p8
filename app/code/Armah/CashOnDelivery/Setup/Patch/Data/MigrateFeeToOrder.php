<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Setup\Patch\Data;

use Armah\CashOnDelivery\Api\Data\PaymentFeeInterface;
use Armah\CashOnDelivery\Model\ResourceModel\PaymentFee;
use Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Select;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class MigrateFeeToOrder implements DataPatchInterface, PatchVersionInterface
{
    public const FEE_BUNCH_SIZE = 100;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return $this
     */
    public function apply()
    {
        $quoteId = 0;
        do {
            $quoteFeeData = $this->getQuoteFeeData($quoteId);
            if (!empty($quoteFeeData)) {
                $this->insertDataToOrderFee($quoteFeeData);
                $quoteFee = end($quoteFeeData);
                $quoteId = (int)$quoteFee[PaymentFeeInterface::QUOTE_ID];
            }
        } while (!empty($quoteFeeData));

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return '1.4.1';
    }

    /**
     * @param int $quoteId
     * @return array
     */
    private function getQuoteFeeData(int $quoteId): array
    {
        $connection = $this->resourceConnection->getConnection();
        $orderTable = $this->resourceConnection->getTableName('sales_order');
        $quoteFeeTable = $this->resourceConnection->getTableName(PaymentFee::TABLE_NAME);

        $select = $connection->select();
        $select->from(['qfee' => $quoteFeeTable], ['quote_id', 'amount', 'base_amount'])
            ->joinInner(
                ['order' => $orderTable],
                'qfee.quote_id = order.quote_id',
                ['order_id' => 'entity_id']
            )
            ->where('qfee.quote_id > ?', $quoteId)
            ->order('qfee.quote_id ' . Select::SQL_ASC)
            ->limit(self::FEE_BUNCH_SIZE);

        return $connection->fetchAll($select);
    }

    /**
     * @param array $feeArray
     */
    private function insertDataToOrderFee(array $feeArray): void
    {
        $arrayForInsert = [];
        $connection = $this->resourceConnection->getConnection();
        $orderFeeTable = $this->resourceConnection->getTableName(OrderPaymentFee::TABLE_NAME);
        foreach ($feeArray as $fee) {
            unset($fee[PaymentFeeInterface::QUOTE_ID]);
            $arrayForInsert[] = $fee;
        }
        $connection->insertMultiple($orderFeeTable, $arrayForInsert);
    }
}
