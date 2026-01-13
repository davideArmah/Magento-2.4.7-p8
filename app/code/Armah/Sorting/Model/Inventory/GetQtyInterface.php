<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Inventory;

/**
 * This class now works only in catalogsearch_fulltext indexation process
 * for elasticsearch engine compatibility.
 * @see \Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper\Stock::map
 * @see \Armah\Sorting\Model\Elasticsearch\SkuRegistry
 */
interface GetQtyInterface
{
    /**
     * @param string $sku
     * @param string $websiteCode
     * @return null|float
     */
    public function execute(string $sku, string $websiteCode): ?float;
}
