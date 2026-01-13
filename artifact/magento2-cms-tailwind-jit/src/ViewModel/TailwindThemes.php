<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\ViewModel;

use Magento\Framework\App\Area;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;
use Magento\Theme\Model\View\Design;
use function array_combine as zip;
use function array_filter as filter;
use function array_keys as keys;
use function array_map as map;
use function array_reduce as reduce;
use function array_unique as unique;
use function array_values as values;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 * phpcs:disable Magento2.Functions.DiscouragedFunction
 */
class TailwindThemes implements ArgumentInterface, OptionSourceInterface
{
    /**
     * @var ComponentRegistrarInterface
     */
    private $componentRegistrar;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var string[]
     */
    private $allTailwindThemes = [];

    /**
     * @var string[]
     */
    private $storeIdToThemeMap = [];

    /**
     * @var ThemeCollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Design
     */
    private $design;

    /**
     * @var string[]
     */
    private $memoizedParentThemeMap = [];

    public function __construct(
        ComponentRegistrarInterface $componentRegistrar,
        StoreManagerInterface $storeManager,
        ThemeCollectionFactory $themeCollectionFactory,
        Filesystem $filesystem,
        Design $design
    ) {
        $this->componentRegistrar     = $componentRegistrar;
        $this->storeManager           = $storeManager;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->filesystem             = $filesystem;
        $this->design                 = $design;
    }

    private function getAllThemes(): array
    {
        return keys($this->componentRegistrar->getPaths(ComponentRegistrar::THEME));
    }

    private function getAllStoreIds(): array
    {
        return values(filter(map(function (StoreInterface $store): int {
            return (int) $store->getId();
        }, $this->storeManager->getStores(true))));
    }

    private function getStoreIdToThemeMap(): array
    {
        if (!$this->storeIdToThemeMap) {
            $allStoreIds = $this->getAllStoreIds();

            $storeIdToThemeId = map(function ($storeId) {
                return $this->design->getConfigurationDesignTheme(
                    Area::AREA_FRONTEND,
                    [Store::ENTITY => $storeId]
                );
            }, zip($allStoreIds, $allStoreIds));

            $themes = $this->themeCollectionFactory->create();
            $themes->addFieldToFilter('theme_id', ['in' => values($storeIdToThemeId)]);

            $this->storeIdToThemeMap = filter(map(static function ($themeId) use ($themes): string {
                $theme = $themes->getItemById($themeId);
                return $theme ? $theme->getFullPath() : '';
            }, $storeIdToThemeId));
        }
        return $this->storeIdToThemeMap;
    }

    private function getAllTailwindThemes(): array
    {
        if (!$this->allTailwindThemes) {
            $this->allTailwindThemes = filter($this->getAllThemes(), [$this, 'isDescendantOfHyvaReset']);
        }
        return $this->allTailwindThemes;
    }

    public function getStoreIdToTailwindThemeMap(): array
    {
        return filter($this->getStoreIdToThemeMap(), function (string $theme): bool {
            return in_array($theme, $this->getAllTailwindThemes(), true);
        });
    }

    public function getWebsiteToStoreIdsMap(): array
    {
        return reduce($this->storeManager->getStores(true), function (array $map, StoreInterface $store): array {
            $map[(int) $store->getWebsiteId()][] = (int) $store->getId();
            return $map;
        }, []);
    }

    private function isDescendantOfHyvaReset(string $theme): bool
    {
        if (!($parentTheme = $this->getParentTheme($theme))) {
            return false;
        }
        return $parentTheme === 'frontend/Hyva/reset' || $this->isDescendantOfHyvaReset($parentTheme);
    }

    private function getParentTheme(string $theme): string
    {
        if (!isset($this->memoizedParentThemeMap[$theme])) {
            $this->memoizedParentThemeMap[$theme] = $this->determineParentTheme($theme);
        }
        return $this->memoizedParentThemeMap[$theme];
    }

    private function determineParentTheme(string $theme): string
    {
        // Guard against themes not being present any more or registered in the DB with the wrong area
        if (! ($themePath = $this->componentRegistrar->getPath(ComponentRegistrar::THEME, $theme))) {
            return '';
        }
        $xml = $this->slurp($themePath . '/theme.xml');
        return preg_match('#<parent>\s*(?<parentTheme>[^<\s]+)\s*</parent>#im', $xml, $matches)
            ? 'frontend/' . $matches['parentTheme']
            : '';
    }

    private function slurp(string $filePath): string
    {
        $filename = basename($filePath);
        $read     = $this->filesystem->getDirectoryReadByPath(dirname($filePath), DriverPool::FILE);

        return $read->isExist($filename) && $read->isReadable($filename)
            ? $read->readFile($filename)
            : '';
    }

    /**
     * @return string[]
     */
    public function getTailwindThemes(): array
    {
        return unique(values($this->getStoreIdToTailwindThemeMap()));
    }

    public function toOptionArray()
    {
        return map(function (string $theme): array {
            return ['label' => $theme, 'value' => $theme];
        }, $this->getTailwindThemes());
    }
}
