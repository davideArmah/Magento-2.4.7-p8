<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Model;

class SearchPageFlag
{
    /**
     * @var bool
     */
    private $flag = false;

    public function set(bool $flag): void
    {
        $this->flag = $flag;
    }

    public function get(): bool
    {
        return $this->flag;
    }
}
