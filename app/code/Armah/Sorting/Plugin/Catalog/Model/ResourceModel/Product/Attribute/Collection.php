<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Plugin\Catalog\Model\ResourceModel\Product\Attribute;

use Armah\Sorting\Model\Elasticsearch\IsElasticSort;
use Armah\Sorting\Model\Method\GetAttributeCodesForSorting;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection as AttributeCollection;
use Magento\Framework\DB\Select;

class Collection
{
    /**
     * @var IsElasticSort
     */
    private $isElasticSort;

    /**
     * @var GetAttributeCodesForSorting
     */
    private $getAttributeCodesForSorting;

    public function __construct(
        IsElasticSort $isElasticSort,
        GetAttributeCodesForSorting $getAttributeCodesForSorting
    ) {
        $this->isElasticSort = $isElasticSort;
        $this->getAttributeCodesForSorting = $getAttributeCodesForSorting;
    }

    /**
     * @param AttributeCollection $subject
     * @param AttributeCollection $result
     * @return AttributeCollection
     */
    public function afterAddToIndexFilter($subject, $result)
    {
        if ($this->isElasticSort->execute(true)) {
            $parts = $result->getSelect()->getPart(Select::WHERE);
            $conditions = array_pop($parts);
            $newCondition = $result->getConnection()->quoteInto(
                'main_table.attribute_code IN (?)',
                $this->getAttributeCodesForSorting->execute()
            );
            $conditions = str_replace(
                'additional_table.is_searchable',
                $newCondition . ' OR additional_table.is_searchable',
                $conditions
            );
            $parts[] = $conditions;
            $result->getSelect()->setPart(Select::WHERE, $parts);
        }

        return $result;
    }
}
