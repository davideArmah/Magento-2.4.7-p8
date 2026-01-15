<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Inventory\CatalogInventory;

use Armah\Sorting\Model\ConfigProvider;
use Armah\Sorting\Model\Inventory\GetQtyInterface;
use Armah\Sorting\Model\ResourceModel\CatalogInventory\GetGroupedQty as GetGroupedQtyResource;

class GetGroupedQty implements GetQtyInterface
{
    /**
     * @var GetGroupedQtyResource
     */
    private $getGroupedQtyResource;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(GetGroupedQtyResource $getGroupedQtyResource, ConfigProvider $configProvider)
    {
        $this->getGroupedQtyResource = $getGroupedQtyResource;
        $this->configProvider = $configProvider;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(string $sku, string $websiteCode): ?float
    {
        return $this->getGroupedQtyResource->execute($sku, $this->configProvider->getQtyOutStock());
    }
}
