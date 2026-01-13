<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Request\Url;

use Armah\Base\Model\Config;

class Builder
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function build($path, $params = []): string
    {
        $apiUrl = $this->config->getLicenceServiceApiUrl();
        $requestParams = [$apiUrl, $path];
        if (!empty($params)) {
            $requestParams[] = '?';
            $requestParams[] = http_build_query($params);
        }

        return implode('', $requestParams);
    }
}
