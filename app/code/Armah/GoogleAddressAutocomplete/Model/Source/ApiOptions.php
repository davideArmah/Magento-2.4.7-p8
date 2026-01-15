<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Address Autocomplete for Magento 2 (System)
 */

namespace Armah\GoogleAddressAutocomplete\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ApiOptions implements OptionSourceInterface
{
    public const PLACES_DATA = 'places_data';

    public const PLACES_OLD = 'places_old';

    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::PLACES_DATA,
                'label' => __('Place Autocomplete Data API')
            ],
            [
                'value' => self::PLACES_OLD,
                'label' => __('Places API (deprecated)')
            ]
        ];
    }
}
