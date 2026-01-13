<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Inventory;

use Armah\Sorting\Model\Elasticsearch\SkuRegistry;

class GetQtyByType implements GetQtyInterface
{
    /**
     * @var SkuRegistry
     */
    private $skuRegistry;

    /**
     * @var GetQtyInterface
     */
    private $defaultQtyResolver;

    /**
     * @var GetQtyInterface[]
     */
    private $resolversByType;

    public function __construct(
        SkuRegistry $skuRegistry,
        GetQtyInterface $defaultQtyResolver,
        array $resolversByType = []
    ) {
        $this->skuRegistry = $skuRegistry;
        $this->resolversByType = $resolversByType;
        $this->defaultQtyResolver = $defaultQtyResolver;
    }

    /**
     * @param string $sku
     * @param string $websiteCode
     * @return null|float
     */
    public function execute(string $sku, string $websiteCode): ?float
    {
        $typeId = $this->skuRegistry->getType($sku);
        $qtyResolver = $this->resolversByType[$typeId] ?? $this->defaultQtyResolver;

        return $qtyResolver->execute($sku, $websiteCode);
    }
}
