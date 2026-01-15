<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\CustomField;

use Magento\Framework\App\ResourceConnection;

class CustomerForm
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

    public function addFormForAttribute(array $data)
    {
        $tableName = $this->resourceConnection->getTableName('customer_form_attribute');
        $this->resourceConnection->getConnection()->insertOnDuplicate($tableName, $data);
    }
}
