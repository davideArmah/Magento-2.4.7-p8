<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel\Field\Collection;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\ResourceModel\Field\Collection;

class FilterByAttributeAndStore
{
    /**
     * @param Collection $collection
     * @param int $attributeId
     * @param int[]|string[] $storeIds
     * @return void
     */
    public function execute(Collection $collection, int $attributeId, array $storeIds): void
    {
        $collection->addFieldToFilter(Field::ATTRIBUTE_ID, $attributeId);
        $collection->addFieldToFilter(Field::STORE_ID, ['in' => $storeIds]);
    }
}
