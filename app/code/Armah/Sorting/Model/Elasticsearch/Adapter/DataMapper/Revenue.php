<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper;

use Armah\Sorting\Model\Elasticsearch\Adapter\IndexedDataMapper;

class Revenue extends IndexedDataMapper
{
    public const FIELD_NAME = 'revenue';

    public function getIndexerCode(): string
    {
        return 'armah_sorting_revenue';
    }
}
