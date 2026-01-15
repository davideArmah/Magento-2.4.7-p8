<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\Ip;

class GdprMaskIp
{
    public function execute(string $ip): string
    {
        return $this->mask($ip);
    }

    private function mask(string $ip): string
    {
        $separator = $this->getSeparator($ip);

        $addressParts = explode($separator, $ip);
        array_pop($addressParts);
        $addressParts[] = '0'; // Mask IP according to EU GDPR law

        return implode($separator, $addressParts);
    }

    private function getSeparator(string $ip): string
    {
        return (bool)filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
            ? ':'
            : '.';
    }
}
