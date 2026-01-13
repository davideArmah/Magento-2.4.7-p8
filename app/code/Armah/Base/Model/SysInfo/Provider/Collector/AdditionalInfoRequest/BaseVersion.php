<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector\AdditionalInfoRequest;

use Armah\Base\Model\ModuleInfoProvider;
use Armah\Base\Model\SysInfo\Provider\Collector\CollectorInterface;

class BaseVersion implements CollectorInterface
{
    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        ModuleInfoProvider $moduleInfoProvider
    ) {
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    public function get()
    {
        $moduleInfo = $this->moduleInfoProvider->getModuleInfo('Armah_Base');

        return $moduleInfo[ModuleInfoProvider::MODULE_VERSION_KEY] ?? '';
    }
}
