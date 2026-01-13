<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model;

use Armah\Base\Model\ConfigProviderAbstract;

class ConfigProvider extends ConfigProviderAbstract
{
    public const REFRESH_IP_BEHAVIOR = 'refresh_ip_database/behaviour';

    /**
     * @var string
     */
    protected $pathPrefix = 'amgeoip/';

    public function getRefreshIpBehaviour(): int
    {
        return (int)$this->getValue(self::REFRESH_IP_BEHAVIOR);
    }
}
