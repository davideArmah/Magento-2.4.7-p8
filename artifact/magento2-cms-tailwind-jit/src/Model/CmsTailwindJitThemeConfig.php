<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Model;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\Serialize\Serializer\Json;

// phpcs:disable Magento2.Functions.DiscouragedFunction

class CmsTailwindJitThemeConfig
{
    private const CMS_JIT_THEME_CONFIG_FILE = 'etc/cms-tailwind-jit-theme-config.json';

    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Json
     */
    private $json;

    public function __construct(ComponentRegistrar $componentRegistrar, Filesystem $filesystem, Json $json)
    {
        $this->componentRegistrar = $componentRegistrar;
        $this->filesystem         = $filesystem;
        $this->json = $json;
    }

    public function getThemeCmsJitConfig(string $theme): array
    {
        try {
            $basePath = $this->componentRegistrar->getPath(ComponentRegistrar::THEME, $theme);
            $json = $this->slurp($basePath . '/' . self::CMS_JIT_THEME_CONFIG_FILE);
            return $this->json->unserialize($json ?: '{}');
        } catch (\InvalidArgumentException $exception) {
            return [];
        }
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
