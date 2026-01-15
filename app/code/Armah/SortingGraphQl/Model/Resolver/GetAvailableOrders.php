<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Model\Resolver;

use Armah\Sorting\Model\Catalog\Toolbar\GetDefaultDirection;
use Magento\Catalog\Model\Config as CatalogConfig;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetAvailableOrders implements ResolverInterface
{
    /**
     * @var CatalogConfig
     */
    private $catalogConfig;

    /**
     * @var GetDefaultDirection
     */
    private $getDefaultDirection;

    public function __construct(CatalogConfig $catalogConfig, GetDefaultDirection $getDefaultDirection)
    {
        $this->catalogConfig = $catalogConfig;
        $this->getDefaultDirection = $getDefaultDirection;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(Field $field, $context, ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $result = [];

        foreach ($this->catalogConfig->getAttributeUsedForSortByArray() as $code => $label) {
            $result[] = [
                'attribute' => $code,
                'id' => $code,
                'text' => $label,
                'sortDirection' => strtoupper($this->getDefaultDirection->execute($code))
            ];
        }

        return $result;
    }
}
