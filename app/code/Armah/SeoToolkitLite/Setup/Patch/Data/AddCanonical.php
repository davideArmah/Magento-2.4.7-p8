<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Setup\Patch\Data;

use Armah\SeoToolkitLite\Model\RegistryConstants;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddCanonical implements DataPatchInterface, PatchRevertableInterface
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
        if ($eavSetup->getAttribute(Product::ENTITY, RegistryConstants::ARTOOLKIT_CANONICAL, 'attribute_id')) {
            $this->updateAttribute($eavSetup);
        } else {
            $this->addAttributes($eavSetup);
        }

        return $this;
    }

    private function updateAttribute(EavSetup $eavSetup): void
    {
        $attribute = $eavSetup->getAttribute(Product::ENTITY, RegistryConstants::ARTOOLKIT_ROBOTS);
        $eavSetup->updateAttribute(
            Product::ENTITY,
            $attribute['attribute_id'],
            'source_model',
            \Armah\SeoToolkitLite\Model\Source\Eav\Robots::class
        );
    }

    private function addAttributes(EavSetup $eavSetup): void
    {
        $eavSetup->addAttribute(
            Product::ENTITY,
            RegistryConstants::ARTOOLKIT_CANONICAL,
            [
                'type' => 'varchar',
                'label' => 'Canonical Link',
                'input' => 'text',
                'required' => false,
                'sort_order' => 100,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible' => false,
                'group' => 'Search Engine Optimization',
            ]
        );

        $eavSetup->addAttribute(
            Product::ENTITY,
            RegistryConstants::ARTOOLKIT_ROBOTS,
            [
                'type' => 'varchar',
                'label' => 'Robots',
                'input' => 'select',
                'source' => \Armah\SeoToolkitLite\Model\Source\Eav\Robots::class,
                'required' => false,
                'sort_order' => 110,
                'default' => 0,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'visible' => false,
                'group' => 'Search Engine Optimization',
            ]
        );
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
        $eavSetup->removeAttribute(Product::ENTITY, RegistryConstants::ARTOOLKIT_ROBOTS);
        $eavSetup->removeAttribute(Product::ENTITY, RegistryConstants::ARTOOLKIT_CANONICAL);
    }
}
