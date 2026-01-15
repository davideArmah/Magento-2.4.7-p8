<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Setup\Patch\Data;

use Armah\SeoToolkitLite\Model\RegistryConstants;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddRobots implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        if (!$eavSetup->getAttribute(Category::ENTITY, RegistryConstants::ARTOOLKIT_ROBOTS)) {
            $eavSetup->addAttribute(
                Category::ENTITY,
                RegistryConstants::ARTOOLKIT_ROBOTS,
                [
                    'type' => 'varchar',
                    'label' => 'Robots',
                    'input' => 'select',
                    'source' => \Armah\SeoToolkitLite\Model\Source\Eav\Robots::class,
                    'required' => false,
                    'visible'  => true,
                    'sort_order' => 110,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'Search Engine Optimization'
                ]
            );
        }

        return $this;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function revert(): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(Category::ENTITY, RegistryConstants::ARTOOLKIT_ROBOTS);
    }
}
