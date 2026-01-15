<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class RefreshIpBehaviour implements OptionSourceInterface
{
    public const MANUALLY = 0;
    public const VIA_ARMAH_SERVICE = 1;

    public function toOptionArray(): array
    {
        return [
            ['value' => self::MANUALLY, 'label' => __('Manually')],
            ['value' => self::VIA_ARMAH_SERVICE, 'label' => __('Update via Armah service')]
        ];
    }
}
