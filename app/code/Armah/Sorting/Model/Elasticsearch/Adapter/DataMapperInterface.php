<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter;

interface DataMapperInterface
{
    /**
     * Prepare index data for using in search engine metadata
     *
     * @param int $entityId
     * @param array $entityIndexData
     * @param int $storeId
     * @param array $context
     * @return array
     */
    public function map(int $entityId, array $entityIndexData, int $storeId, ?array $context = []): array;

    public function isAllowed(int $storeId): bool;
}
