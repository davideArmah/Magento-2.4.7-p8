<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

use function array_walk as walk;

class RemoveWrapperClassFromGeneratedStyles implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var string[]
     */
    private $jitTables = [];

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        array $tables = [
            \Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCategoryTailwindCss::TABLE,
            \Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCmsBlockTailwindCss::TABLE,
            \Hyva\CmsTailwindJit\Observer\Adminhtml\PersistCmsPageTailwindCss::TABLE,
            \Hyva\CmsTailwindJit\Observer\Adminhtml\PersistProductTailwindCss::TABLE,
        ]
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->jitTables       = $tables;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->beginTransaction();

        walk($this->jitTables, [$this, 'updateStylesInTable']);

        $this->moduleDataSetup->getConnection()->commit();
    }

    public function updateStylesInTable(string $table): void
    {
        $query = $this->moduleDataSetup->getConnection()->select()
                                       ->from($this->moduleDataSetup->getTable($table), ['id', 'css']);
        $rows  = $this->moduleDataSetup->getConnection()->fetchAll($query);
        walk($rows, function (array $row) use ($table): void {
            $updatedStyles = $this->removeWrapperClassFromStyles($row['css']);
            $this->moduleDataSetup->updateTableRow($table, 'id', $row['id'], 'css', $updatedStyles);
        });
    }

    public function removeWrapperClassFromStyles(string $styles): string
    {
        return preg_replace('/\.jit-[^\s]+\s+([^{]+)/', '$1', $styles);
    }
}
