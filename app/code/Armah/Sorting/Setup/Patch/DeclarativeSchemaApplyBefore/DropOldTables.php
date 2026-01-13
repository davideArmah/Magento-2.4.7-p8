<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Setup\Patch\DeclarativeSchemaApplyBefore;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class DropOldTables implements SchemaPatchInterface
{
    public const TABLES = [
        'armah_sorting_yotpo',
        'armahsorting_bestsellers',
        'armahsorting_most_viewed',
        'armahsorting_wished',
        'armah_sorting_bestsellers',
        'armah_sorting_most_viewed',
        'armah_sorting_wished'
    ];

    /**
     * @var SchemaSetupInterface
     */
    private $schemaSetup;

    public function __construct(
        SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    public function apply(): DropOldTables
    {
        $connection = $this->schemaSetup->getConnection();

        foreach (self::TABLES as $table) {
            $tableName = $this->schemaSetup->getTable($table);

            if ($connection->isTableExists($tableName)) {
                $connection->dropTable($tableName);
            }
        }

        return $this;
    }
}
