<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\ViewModel;

use Magento\Framework\App\Config\MutableScopeConfigInterface;
use Magento\Framework\View\DesignInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

class TailwindThemesTest extends TestCase
{
    /**
     * @magentoConfigFixture default_store design/theme/theme_id 5
     */
    public function testDeterminesNonHyvaTheme(): void
    {
        // The magentoConfigFixture annotation stopped working, but setting the value on the test config still works.
        $config = Bootstrap::getObjectManager()->get(MutableScopeConfigInterface::class);
        $config->setValue(DesignInterface::XML_PATH_THEME_ID, 5, ScopeInterface::SCOPE_STORE, 'default');

        /** @var TailwindThemes $sut */
        $sut = ObjectManager::getInstance()->create(TailwindThemes::class);
        $this->assertSame([1 => 'frontend/Hyva/default'], $sut->getStoreIdToTailwindThemeMap());
    }
}
