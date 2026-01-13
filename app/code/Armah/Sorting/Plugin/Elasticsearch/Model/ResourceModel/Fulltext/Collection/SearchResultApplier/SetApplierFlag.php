<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Plugin\Elasticsearch\Model\ResourceModel\Fulltext\Collection\SearchResultApplier;

use Armah\Sorting\Model\Elasticsearch\ApplierFlag;
use Magento\Elasticsearch\Model\ResourceModel\Fulltext\Collection\SearchResultApplier;

class SetApplierFlag
{
    /**
     * @var ApplierFlag
     */
    private $applierFlag;

    public function __construct(ApplierFlag $applierFlag)
    {
        $this->applierFlag = $applierFlag;
    }

    public function aroundApply(SearchResultApplier $subject, callable $proceed): void
    {
        $this->applierFlag->enable();
        $proceed();
        $this->applierFlag->disable();
    }
}
