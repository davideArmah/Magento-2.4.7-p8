<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Plugin\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;

use Armah\Sorting\Model\Elasticsearch\ApplierFlag;
use Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;

class PreventPriceSortingOnMysql
{
    /**
     * @var ApplierFlag
     */
    private $applierFlag;

    public function __construct(ApplierFlag $applierFlag)
    {
        $this->applierFlag = $applierFlag;
    }

    public function afterIsUsingPriceIndex(ProductLimitation $subject, bool $result): bool
    {
        if ($this->applierFlag->get()) {
            $result = false;
        }

        return $result;
    }
}
