<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch;

class ApplierFlag
{
    /**
     * @var bool
     */
    private $flag = false;

    public function enable(): void
    {
        $this->flag = true;
    }

    public function disable(): void
    {
        $this->flag = false;
    }

    public function get(): bool
    {
        return $this->flag;
    }
}
