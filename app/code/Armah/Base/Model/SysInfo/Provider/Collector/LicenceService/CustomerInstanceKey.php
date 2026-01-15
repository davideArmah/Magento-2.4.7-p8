<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector\LicenceService;

use Armah\Base\Model\Config;
use Armah\Base\Model\SysInfo\Provider\Collector\CollectorInterface;

class CustomerInstanceKey implements CollectorInterface
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function get()
    {
        return $this->config->getLicenseKeys();
    }
}
