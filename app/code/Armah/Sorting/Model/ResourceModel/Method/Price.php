<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\ResourceModel\Method;

class Price extends AbstractMethod
{
    /**
     * {@inheritdoc}
     */
    public function apply($collection, $direction)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function getIndexedValues(int $storeId, ?array $entityIds = [])
    {
        return [];
    }
}
