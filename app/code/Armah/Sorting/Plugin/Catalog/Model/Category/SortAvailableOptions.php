<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Plugin\Catalog\Model\Category;

use Armah\Sorting\Model\Method\IsMethodDisplayed;
use Armah\Sorting\Model\Source\SortOptions;
use Magento\Catalog\Model\Category;

class SortAvailableOptions
{
    /**
     * @var SortOptions
     */
    private $sortOptions;

    /**
     * @var IsMethodDisplayed
     */
    private $isMethodDisplayed;

    public function __construct(
        SortOptions $sortOptions,
        IsMethodDisplayed $isMethodDisplayed
    ) {
        $this->sortOptions = $sortOptions;
        $this->isMethodDisplayed = $isMethodDisplayed;
    }

    /**
     * @param Category $subject
     * @param array $options
     * @return array
     * @see \Magento\Catalog\Model\Category::getAvailableSortBy
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAvailableSortBy(Category $subject, ?array $options): ?array
    {
        if ($options) {
            if (!$this->isMethodDisplayed->execute('position')) {
                unset($options['position']);
            }

            $options = array_flip($this->sortOptions->execute(array_flip($options)));
        }

        return $options;
    }
}
