<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Indexer\Conditions;

class ProductIndexer extends AbstractIndexer
{
    public const TYPE = 'product';

    protected function getType(): string
    {
        return self::TYPE;
    }
}
