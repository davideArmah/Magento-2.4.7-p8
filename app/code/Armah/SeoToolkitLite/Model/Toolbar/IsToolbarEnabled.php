<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Toolbar;

use Armah\Base\Model\GetCustomerIp;
use Armah\SeoToolkitLite\Model\ConfigProvider;

class IsToolbarEnabled
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var GetCustomerIp
     */
    private $customerIp;

    public function __construct(
        ConfigProvider $configProvider,
        GetCustomerIp $customerIp
    ) {
        $this->configProvider = $configProvider;
        $this->customerIp = $customerIp;
    }

    public function execute(): bool
    {
        $isEnabled = $this->configProvider->isToolbarEnabled();
        if ($isEnabled) {
            $ips = $this->configProvider->getToolbarIps();
            if ($ips) {
                $current = $this->customerIp->getCurrentIp();
                if (!in_array($current, $ips)) {
                    $isEnabled = false;
                }
            }
        }

        return $isEnabled;
    }
}
