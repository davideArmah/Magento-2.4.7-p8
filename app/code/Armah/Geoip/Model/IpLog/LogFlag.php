<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\IpLog;

use Magento\Customer\Model\Session as CustomerSession;

class LogFlag
{
    public const FLAG_NAME = 'armah_geoip_ip_logged';

    /**
     * @var CustomerSession
     */
    private $customerSession;

    public function __construct(
        CustomerSession $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    public function isLogged(): bool
    {
        return $this->customerSession->getData(self::FLAG_NAME) === true;
    }

    public function setIsLogged(): void
    {
        $this->customerSession->setData(self::FLAG_NAME, true);
    }
}
