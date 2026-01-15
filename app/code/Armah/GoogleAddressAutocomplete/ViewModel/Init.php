<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Address Autocomplete for Magento 2 (System)
 */

namespace Armah\GoogleAddressAutocomplete\ViewModel;

use Armah\GoogleAddressAutocomplete\Model\ConfigProvider;
use Armah\GoogleAddressAutocomplete\Model\GetRegionsList;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Init implements ArgumentInterface
{
    public function __construct(
        private readonly GetRegionsList $getRegionsList,
        private readonly Json $jsonSerializer,
        private readonly ConfigProvider $configProvider
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->configProvider->isAddressSuggestionEnabled();
    }

    public function getApiType(): string
    {
        return $this->configProvider->getSelectedApi();
    }

    public function getApiKey(): ?string
    {
        return $this->configProvider->resolveApiKeys();
    }

    /**
     * @deprecated
     */
    public function getOptions(): array
    {
        return [
            'regions' => $this->getRegionsList->execute()
        ];
    }

    /**
     * @deprecated
     */
    public function getOptionsJson(): string
    {
        return $this->jsonSerializer->serialize($this->getOptions());
    }

    public function getRegionsJson(): string
    {
        return $this->jsonSerializer->serialize($this->getRegionsList->execute());
    }

    /**
     * @deprecated
     */
    public function getRestrictedCountryList(): string
    {
        $countriesArray = [];
        if (!empty($countriesString = $this->configProvider->getRestrictedCountryList())) {
            $countriesArray = explode(',', $countriesString);
        }

        return $this->jsonSerializer->serialize($countriesArray);
    }

    public function getIncludedCountiesJson(): string
    {
        $counties = $this->configProvider->getIncludedCounties();

        if (empty($counties)) {
            return $this->jsonSerializer->serialize([]);
        }

        return $this->jsonSerializer->serialize($counties);
    }
}
