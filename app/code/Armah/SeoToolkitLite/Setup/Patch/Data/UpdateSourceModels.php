<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Migrates EAV attribute source_model from Amasty to Armah namespace
 */
class UpdateSourceModels implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var array
     */
    private $sourceModelMigrations = [
        'Amasty\\SeoToolkitLite\\Model\\Source\\Eav\\Robots' => 'Armah\\SeoToolkitLite\\Model\\Source\\Eav\\Robots',
        'Amasty\\SeoToolkitLite\\Model\\Source\\Eav\\Canonical' => 'Armah\\SeoToolkitLite\\Model\\Source\\Eav\\Canonical'
    ];

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('eav_attribute');

        foreach ($this->sourceModelMigrations as $oldSourceModel => $newSourceModel) {
            $connection->update(
                $tableName,
                ['source_model' => $newSourceModel],
                ['source_model = ?' => $oldSourceModel]
            );
        }

        return $this;
    }

    public static function getDependencies()
    {
        return [
            AddRobots::class,
            AddCanonical::class
        ];
    }

    public function getAliases()
    {
        return [];
    }
}
