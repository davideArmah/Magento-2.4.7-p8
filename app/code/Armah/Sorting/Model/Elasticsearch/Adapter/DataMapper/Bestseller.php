<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper;

use Armah\Sorting\Model\Elasticsearch\Adapter\IndexedDataMapper;

class Bestseller extends IndexedDataMapper
{
    public const FIELD_NAME = 'bestsellers';

    /**
     * @inheritdoc
     */
    public function getIndexerCode()
    {
        return 'armah_sorting_bestseller';
    }
}
