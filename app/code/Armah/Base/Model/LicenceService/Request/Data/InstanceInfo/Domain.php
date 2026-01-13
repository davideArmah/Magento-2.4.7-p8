<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Request\Data\InstanceInfo;

use Armah\Base\Model\SimpleDataObject;

class Domain extends SimpleDataObject
{
    public const URL = 'url';

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getData(self::URL);
    }
}
