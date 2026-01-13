<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\ResourceModel\Method;

class Commented extends Toprated
{
    /**
     * Returns Sorting method Table Column name
     * which is using for order collection
     *
     * @return string
     */
    public function getSortingColumnName()
    {
        return 'reviews_count';
    }

    public function getSortingFieldName(): string
    {
        return $this->configProvider->isYotpoReviewsEnabled($this->getStoreId())
            ? 'total_reviews'
            : 'reviews_count';
    }
}
