<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper;

use Armah\Sorting\Model\Elasticsearch\Adapter\IndexedDataMapper;

class MostViewed extends IndexedDataMapper
{
    public const FIELD_NAME = 'most_viewed';

    /**
     * @inheritdoc
     */
    public function getIndexerCode()
    {
        return 'armah_sorting_most_viewed';
    }
}
