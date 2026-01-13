<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field;

use Magento\Framework\App\ResourceConnection;

class DeleteAttributeFrontendLabel
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    public function execute(int $attributeId, int $storeId): void
    {
        $connection = $this->resourceConnection->getConnection();
        $condition = ['attribute_id = ?' => $attributeId, 'store_id = ?' => $storeId];
        $connection->delete($this->resourceConnection->getTableName('eav_attribute_label'), $condition);
    }
}
