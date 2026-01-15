<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\Framework\Setup\Patch;

use Armah\Base\Model\Uninstall\DeclarationDbSchema;
use Magento\Framework\Setup\Patch\PatchApplier;

/**
 * @since 1.21.0
 */
class DeleteArmahTablesPlugin
{
    /**
     * @var DeclarationDbSchema
     */
    private DeclarationDbSchema $schemaDelete;

    public function __construct(
        DeclarationDbSchema $schemaDelete
    ) {
        $this->schemaDelete = $schemaDelete;
    }

    /**
     * @see \Magento\Framework\Setup\Patch\PatchApplier::revertDataPatches
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeRevertDataPatches(PatchApplier $subject, ?string $moduleName = null): void
    {
        if (!$moduleName || strpos($moduleName, 'Armah_') !== 0) {
            return;
        }

        $this->schemaDelete->uninstallModule($moduleName);
    }
}
