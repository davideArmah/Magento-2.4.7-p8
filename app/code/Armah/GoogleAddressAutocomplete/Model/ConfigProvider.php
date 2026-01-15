<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Address Autocomplete for Magento 2 (System)
 */

namespace Armah\GoogleAddressAutocomplete\Model;

use Armah\Base\Model\ConfigProviderAbstract;
use Armah\GoogleAddressAutocomplete\Model\Source\ApiOptions;

class ConfigProvider extends ConfigProviderAbstract
{
    public const PATH_PREFIX = 'armah_address_autocomplete/';

    public const IS_ENABLED = 'general/google_address_suggestion';
    public const API_KEY = 'general/google_api_key';
    public const AUTOCOMPLETE_COUNTRY_RESTRICTIONS = 'general/autocomplete_country_restrictions';

    public const SELECTED_API = 'general/selected_api';

    /**
     * @var string
     */
    protected $pathPrefix = self::PATH_PREFIX;

    /**
     * @return bool
     */
    public function isAddressSuggestionEnabled(): bool
    {
        return $this->isSetFlag(self::IS_ENABLED);
    }

    /**
     * @see ApiOption
     */
    public function getSelectedApi(?int $storeId = null): string
    {
        return $this->getValue(self::SELECTED_API, $storeId);
    }

    /**
     * @return string|null
     * @deprecated
     */
    public function getGoogleMapsKey(): ?string
    {
        return $this->getValue(self::API_KEY);
    }

    /**
     * @return string|null
     * @deprecated
     */
    public function getRestrictedCountryList(): ?string
    {
        return $this->getValue(self::AUTOCOMPLETE_COUNTRY_RESTRICTIONS);
    }

    public function getPlacesApiKey(?int $storeId = null): ?string
    {
        return $this->getValue('general/google_api_key_new', $storeId);
    }

    /**
     * @return string[]|null
     */
    public function getIncludedCounties(?int $storeId = null): ?array
    {
        $value = $this->getValue('general/countries_for_autocomplete', $storeId);

        if (!empty($value)) {
            return array_slice(explode(',', $value), 0, 15);
        }

        return null;
    }

    public function resolveApiKeys(?int $storeId = null): ?string
    {
        return match ($this->getSelectedApi($storeId)) {
            ApiOptions::PLACES_DATA => $this->getPlacesApiKey($storeId),
            ApiOptions::PLACES_OLD => $this->getGoogleMapsKey($storeId),
            default => null,
        };
    }
}
