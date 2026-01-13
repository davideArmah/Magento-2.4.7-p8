<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Model\ResourceModel\Delivery;

use Armah\CheckoutDeliveryDate\Model\Delivery;
use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Delivery::class, \Armah\CheckoutDeliveryDate\Model\ResourceModel\Delivery::class);
    }

    /**
     * @param array $quoteIds
     */
    public function addSizeSelectByQuoteIds(array $quoteIds = []): void
    {
        $this->addFieldToFilter('quote_id', ['in' => $quoteIds]);
        $this->getSelect()->reset(Select::COLUMNS);
        $this->getSelect()->columns(['size' => new \Zend_Db_Expr('COUNT(*)')]);
    }
}
