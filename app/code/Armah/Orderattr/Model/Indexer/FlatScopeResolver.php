<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Indexer;

class FlatScopeResolver extends \Magento\Framework\Indexer\ScopeResolver\FlatScopeResolver
{
    public function resolve($index, array $dimensions)
    {
        $result = parent::resolve($index, $dimensions);

        foreach ($dimensions as $dimension) {
            $result .= $dimension->getValue();
        }

        return $result;
    }
}
