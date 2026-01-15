<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector\CacheService\Info;

interface CacheInfoInterface
{
    public function getName(): ?string;
    public function setName(string $name): void;
    public function getStatus(): ?string;
    public function setStatus(string $status): void;
    public function getAdditionalInfo(): ?string;
    public function setAdditionalInfo(string $additionalInfo): void;
}
