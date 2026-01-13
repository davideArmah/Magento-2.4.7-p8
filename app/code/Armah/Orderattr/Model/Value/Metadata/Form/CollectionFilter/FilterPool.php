<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Value\Metadata\Form\CollectionFilter;

class FilterPool
{
    /**
     * @var FilterInterface[]
     */
    private $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @throws \InvalidArgumentException
     * @SuppressWarnings(PHPMD.MissingImport)
     * @return FilterInterface[]
     */
    public function getAll(): array
    {
        foreach ($this->filters as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException(
                    sprintf('Filter must implement %s', FilterInterface::class)
                );
            }
        }

        return $this->filters;
    }
}
