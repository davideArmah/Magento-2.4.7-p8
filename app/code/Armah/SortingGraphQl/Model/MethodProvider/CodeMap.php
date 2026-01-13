<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Model\MethodProvider;

class CodeMap
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @param string $methodCode
     * @param string $alias
     * @return void
     */
    public function set(string $methodCode, string $alias): void
    {
        $this->map[$alias] = $methodCode;
    }

    /**
     * @param string $alias
     * @return string|null
     */
    public function get(string $alias): ?string
    {
        return $this->map[$alias] ?? null;
    }

    /**
     * @return array [alias => methodCode, ...]
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array|null $map [alias => methodCode, ...]
     */
    public function setMap(?array $map): void
    {
        $this->map = $map;
    }
}
