<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\Sorting\Model\IsSearchPage;

use Armah\Sorting\Model\IsSearchPage;
use Armah\SortingGraphQl\Model\SearchPageFlag;

class DetectSearchPage
{
    /**
     * @var SearchPageFlag
     */
    private $searchPageFlag;

    public function __construct(SearchPageFlag $searchPageFlag)
    {
        $this->searchPageFlag = $searchPageFlag;
    }

    /**
     * @param IsSearchPage $subject
     * @return bool
     */
    public function aroundExecute(IsSearchPage $subject): bool
    {
        return $this->searchPageFlag->get();
    }
}
