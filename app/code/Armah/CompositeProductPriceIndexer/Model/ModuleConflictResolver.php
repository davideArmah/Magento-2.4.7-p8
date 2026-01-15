<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Composite Product Price Indexer
 */

namespace Armah\CompositeProductPriceIndexer\Model;

use Magento\Framework\Module\Manager;

/**
 * Temporal Class to resolve conflicts between modules
 * Remove after all conflicted modules will be using this one
 */
class ModuleConflictResolver
{
    /**
     * @var string[]
     */
    private $modules;

    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(
        Manager $moduleManager,
        array $modules = []
    ) {
        $this->modules = $modules;
        $this->moduleManager = $moduleManager;
    }

    public function hasConflicts(): bool
    {
        foreach ($this->modules as $module) {
            if ($this->moduleManager->isEnabled($module)) {
                return true;
            }
        }

        return false;
    }
}
