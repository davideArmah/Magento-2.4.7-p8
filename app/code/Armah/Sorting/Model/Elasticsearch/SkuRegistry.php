<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch;

use Armah\Sorting\Model\ResourceModel\Product\LoadSkuMap;
use Armah\Sorting\Model\ResourceModel\Product\LoadTypeMap;

class SkuRegistry
{
    /**
     * Where key is entityId; value is sku.
     * @var array|null
     */
    private $skuRelations;

    /**
     * Where key is sku; value is typeId.
     * @var array|null
     */
    private $typeRelations;

    /**
     * @var LoadSkuMap
     */
    private $loadSkuMap;

    /**
     * @var LoadTypeMap
     */
    private $loadTypeMap;

    public function __construct(LoadSkuMap $loadSkuMap, LoadTypeMap $loadTypeMap)
    {
        $this->loadSkuMap = $loadSkuMap;
        $this->loadTypeMap = $loadTypeMap;
    }

    /**
     * @param array $entityIds
     * @return void
     */
    public function save(array $entityIds): void
    {
        $this->skuRelations = $this->loadSkuMap->execute($entityIds);
        $this->typeRelations = $this->loadTypeMap->execute(array_values($this->skuRelations));
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->skuRelations = null;
    }

    /**
     * @param int $entityId
     * @return string
     */
    public function getSku(int $entityId): string
    {
        return $this->skuRelations[$entityId] ?? '';
    }

    /**
     * @param string $sku
     * @return string
     */
    public function getType(string $sku): string
    {
        return $this->typeRelations[$sku] ?? '';
    }
}
