<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\CatalogGraphQl\Model\Resolver\Products\Query\Search;

use Armah\SortingGraphQl\Model\SearchPageFlag;
use Magento\CatalogGraphQl\Model\Resolver\Products\Query\Search;

class SetSearchFlag
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
     * @param Search $subject
     * @param array $args
     * @return void
     */
    public function beforeGetResult(Search $subject, array $args): void
    {
        if (isset($args['search'])) {
            $this->searchPageFlag->set(true);
        }
    }
}
