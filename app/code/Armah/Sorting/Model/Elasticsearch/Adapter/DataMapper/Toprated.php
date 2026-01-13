<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper;

use Armah\Sorting\Model\Elasticsearch\Adapter\IndexedDataMapper;

class Toprated extends IndexedDataMapper
{
    public const FIELD_NAME = 'rating_summary_field';

    /**
     * @inheritdoc
     */
    public function getIndexerCode()
    {
        return 'armah_yotpo_review';
    }
}
