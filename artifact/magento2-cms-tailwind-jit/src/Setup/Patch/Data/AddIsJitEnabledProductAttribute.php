<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Setup\Patch\Data;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddIsJitEnabledProductAttribute implements DataPatchInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetup;

    public function __construct(EavSetup $eavSetup)
    {
        $this->eavSetup = $eavSetup;
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
        $this->eavSetup->addAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            'is_tailwindcss_jit_enabled',
            [
                'type'         => 'int',
                'input'        => 'boolean',
                'label'        => 'Generate Hyvä Styles',
                'required'     => 0,
                'user_defined' => 1,
                'default'      => 1,
                'sort_order'   => 3,
                'group'        => 'Content',
            ]
        );
    }
}
