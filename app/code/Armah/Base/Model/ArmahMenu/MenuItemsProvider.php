<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\ArmahMenu;

use Magento\Backend\Model\Menu;
use Magento\Backend\Model\Menu\Config;
use Magento\Backend\Model\Menu\Filter\Iterator;
use Magento\Backend\Model\Menu\Filter\IteratorFactory;
use Magento\Backend\Model\Menu\Item;

class MenuItemsProvider
{
    /**
     * @var IteratorFactory
     */
    private $iteratorFactory;

    /**
     * @var ArmahConfigItemsProvider
     */
    private $configItemsProvider;

    /**
     * @var MenuItemFactory
     */
    private $menuItemFactory;

    /**
     * @var Menu
     */
    private $defaultMenu;

    /**
     * Storage for generated items
     *
     * @var MenuItem[]
     */
    private $armahItems = [];

    public function __construct(
        IteratorFactory $iteratorFactory,
        ArmahConfigItemsProvider $configItemsProvider,
        MenuItemFactory $menuItemFactory,
        Config $menuConfig
    ) {
        $this->iteratorFactory = $iteratorFactory;
        $this->menuItemFactory = $menuItemFactory;
        $this->defaultMenu = $menuConfig->getMenu();
        $this->configItemsProvider = $configItemsProvider;
    }

    /**
     * Get all available Armah Menu Items
     *
     * @return MenuItem[]
     */
    public function get(): array
    {
        if (!$this->armahItems) {
            $resources = $this->getArmahResources($this->defaultMenu);
            $itemsData = [];

            foreach ($resources as $resource) {
                $moduleCode = current(explode('::', $resource));

                // Group all Shopby modules under ShopbyBase
                $groupedModuleCode = $this->getGroupedModuleCode($moduleCode);

                if (!isset($itemsData[$groupedModuleCode])) {
                    $itemsData[$groupedModuleCode][MenuItem::RESOURCES] = [];
                }
                $itemsData[$groupedModuleCode][MenuItem::RESOURCES][] = $resource;
            }

            $configItems = $this->configItemsProvider->getConfigItems();
            foreach ($configItems as $moduleCode => $configData) {
                // Group all Shopby modules under ShopbyBase
                $groupedModuleCode = $this->getGroupedModuleCode($moduleCode);
                // Only set CONFIG for the main module (don't override if already set)
                if (!isset($itemsData[$groupedModuleCode][MenuItem::CONFIG])) {
                    $itemsData[$groupedModuleCode][MenuItem::CONFIG] = $configData;
                }
            }

            foreach ($itemsData as $moduleCode => $itemData) {
                $this->armahItems[$moduleCode] = $this->menuItemFactory->create(['data' => $itemData]);
            }
        }

        return $this->armahItems;
    }

    /**
     * Get grouped module code for menu items
     * Groups all Shopby modules under ShopbyBase
     *
     * @param string $moduleCode
     * @return string
     */
    private function getGroupedModuleCode(string $moduleCode): string
    {
        // Group all Shopby-related modules under Armah_ShopbyBase
        if (strpos($moduleCode, 'Armah_Shopby') === 0 && $moduleCode !== 'Armah_ShopbyBase') {
            return 'Armah_ShopbyBase';
        }

        return $moduleCode;
    }

    /**
     * Get Armah Menu Item by module code
     *
     * @param string $moduleCode
     * @return MenuItem|null
     */
    public function getByModuleCode(string $moduleCode): ?MenuItem
    {
        return $this->get()[$moduleCode] ?? null;
    }

    /**
     * @param Menu $menu
     * @return array
     */
    private function getArmahResources(Menu $menu): array
    {
        $items = [];

        foreach ($this->getMenuIterator($menu) as $menuItem) {
            if ($this->isCollectableNode($menuItem)) {
                $items[] = $menuItem->getId();
            }
            if ($menuItem->hasChildren()) {
                foreach ($this->getArmahResources($menuItem->getChildren()) as $menuChild) {
                    $items[] = $menuChild;
                }
            }
        }

        return $items;
    }

    /**
     * @param Item $menuItem
     * @return bool
     */
    private function isCollectableNode(Item $menuItem): bool
    {
        if (strpos($menuItem->getId(), 'Armah') === false
            || strpos($menuItem->getId(), 'Armah_Base') !== false
        ) {
            return false;
        }

        // Always include SEO Toolkit modules
        $seoModules = [
            'Armah_Meta::',
            'Armah_SeoToolkitLite::',
            'Armah_SeoHtmlSitemap::',
            'Armah_OpenGraphTags::',
            'Armah_SeoRichData::',
            'Armah_SeoSingleUrl::',
            'Armah_RegenerateUrlRewrites::',
            'Armah_CrossLinks::',
            'Armah_XmlSitemap::'
        ];

        foreach ($seoModules as $seoModule) {
            if (strpos($menuItem->getId(), $seoModule) !== false) {
                return true;
            }
        }

        // Always include Improved Layered Navigation modules
        $shopbyModules = [
            'Armah_Shopby::',
            'Armah_ShopbyBase::',
            'Armah_ShopbyBrand::',
            'Armah_ShopbySeo::',
            'Armah_ShopbyPage::'
        ];

        foreach ($shopbyModules as $shopbyModule) {
            if (strpos($menuItem->getId(), $shopbyModule) !== false) {
                return true;
            }
        }

        // For other modules, exclude system_config actions
        if (empty($menuItem->getAction())
            || strpos($menuItem->getAction(), 'system_config') === false
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param Menu $menu
     * @return Iterator
     */
    private function getMenuIterator(Menu $menu): Iterator
    {
        return $this->iteratorFactory->create(['iterator' => $menu->getIterator()]);
    }
}
