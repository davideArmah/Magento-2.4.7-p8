<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Request\Data\InstanceInfo;

use Armah\Base\Model\SimpleDataObject;
use Magento\Framework\Api\ExtensibleDataInterface;

class Platform extends SimpleDataObject implements ExtensibleDataInterface
{
    public const NAME = 'name';
    public const VERSION = 'version';

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self
    {
        return $this->setData(self::VERSION, $version);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getData(self::VERSION);
    }
}
