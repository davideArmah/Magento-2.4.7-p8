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
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 * phpcs:disable Magento2.Functions.DiscouragedFunction
 */
class TailwindConfigs implements ArgumentInterface
{
    private const TAILWIND_JIT_CONFIG_DEFAULT_FILE = 'web/tailwind/tailwind.browser-jit-config.js';

    /**
     * @var ComponentRegistrarInterface
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
        ComponentRegistrarInterface $componentRegistrar,
        Filesystem $filesystem,
        CmsTailwindJitThemeConfig $cmsTailwindJitThemeConfig
    ) {
        $this->componentRegistrar        = $componentRegistrar;
        $this->filesystem                = $filesystem;
        $this->cmsTailwindJitThemeConfig = $cmsTailwindJitThemeConfig;
    }

    /**
     * The contents of a tailwind.browser-jit-config.js file only supports a subset of regular tailwind.config.js files.
     *
     * Only the module.exports.theme config is evaluated
     * No calls to require() or resolveConfig() are allowed inside the module.exports object.
     * Only the following require values can be used (with exactly these const names):
     *
     *   const {spacing} = require('tailwindcss/defaultTheme');
     *   const colors = require('tailwindcss/colors');
     *
     * The remaining configuration will be merged with the default tailwind JIT configuration when compiling the classes
     * for a store view using the theme containing the tailwind/tailwind.browser-jit-config.js file.
     *
     * @param string $rawConfig
     * @return string
     */
    private function extractModuleExportsSection(string $rawConfig): string
    {
        if (preg_match('#module.exports\s*=\s*(?<config>{.*})#s', $rawConfig, $matches)) {
            return preg_replace('#^\s*//.*$#m', '', $matches['config']); // remove comment lines
        }

        // Unable to extract the theme config.
        // todo: maybe log this?
        return '';
    }

    public function getEmbeddableTailwindConfigForTheme(string $theme): string
    {
        return trim($this->extractModuleExportsSection($this->readBrowserJitConfigForTheme($theme)));
    }

    private function readBrowserJitConfigForTheme(string $theme): string
    {
        $themeConfig = $this->cmsTailwindJitThemeConfig->getThemeCmsJitConfig($theme);
        $tailwindConfigPath = $themeConfig['tailwindBrowserJitConfigPath'] ?? self::TAILWIND_JIT_CONFIG_DEFAULT_FILE;
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
