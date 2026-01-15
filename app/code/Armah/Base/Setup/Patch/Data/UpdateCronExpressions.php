<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Setup\Patch\Data;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\Math\Random;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpdateCronExpressions implements DataPatchInterface
{
    private const CONFIG_PATHS = [
        'armah_base/cron/feeds_refresh',
        'armah_base/cron/daily_send_system_info',
        'armah_base/cron/instance_registration'
    ];

    /**
     * @var ConfigInterface
     */
    private $resourceConfig;

    public function __construct(
        ConfigInterface $resourceConfig
    ) {
        $this->resourceConfig = $resourceConfig;
    }

    public function apply(): self
    {
        foreach (self::CONFIG_PATHS as $path) {
            $value = Random::getRandomNumber(0, 59) . ' * * * *';
            $this->resourceConfig->saveConfig($path, $value);
        }

        return $this;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
