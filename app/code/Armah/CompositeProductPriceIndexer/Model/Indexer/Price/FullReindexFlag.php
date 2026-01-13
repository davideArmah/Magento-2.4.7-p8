<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Composite Product Price Indexer
 */

namespace Armah\CompositeProductPriceIndexer\Model\Indexer\Price;

class FullReindexFlag
{
    /**
     * @var bool
     */
    private $flag = false;

    public function isFullReindex(): bool
    {
        return $this->flag;
    }

    public function setIsFullReindex(bool $flag): void
    {
        $this->flag = $flag;
    }
}
