<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Address Autocomplete for Magento 2 (System)
 */

namespace Armah\GoogleAddressAutocomplete\Plugin\Checkout\Block;

use Armah\GoogleAddressAutocomplete\Model\ConfigProvider;
use Armah\GoogleAddressAutocomplete\Model\Source\ApiOptions;
use Magento\Checkout\Block\Checkout\AttributeMerger;

class ReplaceStreetComponent
{
    public function __construct(private readonly ConfigProvider $configProvider)
    {
    }

    /**
     * @see AttributeMerger::merge
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterMerge(AttributeMerger $subject, array $config): array
    {
        if (isset($config['street'])
            && $this->configProvider->isAddressSuggestionEnabled()
            && $this->configProvider->getSelectedApi() === ApiOptions::PLACES_OLD
            && $this->configProvider->getGoogleMapsKey()
        ) {
            $config['street']['children'][0]['component']
                = 'Armah_GoogleAddressAutocomplete/js/form/element/autocomplete';
        }

        return $config;
    }
}
