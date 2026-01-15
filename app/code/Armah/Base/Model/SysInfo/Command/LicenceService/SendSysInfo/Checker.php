<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Command\LicenceService\SendSysInfo;

class Checker
{
    public function isChangedCacheValue(?string $cacheValue, string $newValue): bool
    {
        return !($cacheValue && hash_equals($cacheValue, $newValue));
    }
}
