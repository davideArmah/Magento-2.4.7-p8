<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\ViewModel;

use Hyva\CmsTailwindJit\Model\CmsTailwindJitThemeConfig;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 * phpcs:disable Magento2.Functions.DiscouragedFunction
 */
class ThemeCustomCss implements ArgumentInterface
{
    private const TAILWIND_JIT_CUSTOM_CSS_DEFAULT_FILE = 'web/tailwind/tailwind.browser-jit.css';

    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var CmsTailwindJitThemeConfig
     */
    private $cmsTailwindJitThemeConfig;

    public function __construct(
        ComponentRegistrar $componentRegistrar,
        Filesystem $filesystem,
        CmsTailwindJitThemeConfig $cmsTailwindJitThemeConfig
    ) {
        $this->componentRegistrar = $componentRegistrar;
        $this->filesystem = $filesystem;
        $this->cmsTailwindJitThemeConfig = $cmsTailwindJitThemeConfig;
    }

    public function getCustomCssForTheme(string $theme): string
    {
        return trim($this->readBrowserJitCustomCssForTheme($theme));
    }

    private function readBrowserJitCustomCssForTheme(string $theme): string
    {
        $themeConfig = $this->cmsTailwindJitThemeConfig->getThemeCmsJitConfig($theme);
        $tailwindConfigPath = $themeConfig['tailwindBrowserJitCssPath'] ?? self::TAILWIND_JIT_CUSTOM_CSS_DEFAULT_FILE;
        $file = substr($tailwindConfigPath, 0, 1) === '/'
            ? $tailwindConfigPath
            : $this->componentRegistrar->getPath(ComponentRegistrar::THEME, $theme) . '/' . $tailwindConfigPath;

        return $this->slurp($file);
    }

    private function slurp(string $filePath): string
    {
        $filename = basename($filePath);
        $read     = $this->filesystem->getDirectoryReadByPath(dirname($filePath), DriverPool::FILE);

        return $read->isExist($filename) && $read->isReadable($filename)
            ? $read->readFile($filename)
            : '';
    }
}
