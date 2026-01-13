<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Address Autocomplete for Magento 2 (System)
 */

namespace Armah\GoogleAddressAutocomplete\Model;

use Armah\GoogleAddressAutocomplete\Model\ResourceModel\Region\CollectionFactory;

class GetRegionsList
{
    public function __construct(private readonly CollectionFactory $collectionFactory)
    {
    }

    /**
     * Returns a properly formatted list of regions that follows the following format:
     * [ 'countryId' => ['regionCode' => 'regionId'] ]
     *
     * Used for address form on the checkout.
     *
     * @return array<string, array<string, string>>
     */
    public function execute(): array
    {
        $regions = $this->collectionFactory->create()->fetchRegions();

        $regions['DE']['BW'] = '80';
        $regions['DE']['BY'] = '81';
        $regions['DE']['BE'] = '82';
        $regions['DE']['BB'] = '83';
        $regions['DE']['HB'] = '84';
        $regions['DE']['HH'] = '85';
        $regions['DE']['HE'] = '86';
        $regions['DE']['MV'] = '87';
        $regions['DE']['RP'] = '89';
        $regions['DE']['SL'] = '90';
        $regions['DE']['SN'] = '91';
        $regions['DE']['SA'] = '92';
        $regions['DE']['SH'] = '93';
        $regions['DE']['TH'] = '94';

        $regions['BY']['Bresckaja voblasć'] = '613';
        $regions['BY']['Homieĺskaja voblasć'] = '614';
        $regions['BY']['Horad Minsk'] = '615';
        $regions['BY']['Hrodzienskaja voblasć'] = '616';
        $regions['BY']['Mahilioŭskaja voblasć'] = '617';
        $regions['BY']['Minskaja voblasć'] = '618';
        $regions['BY']['Viciebskaja voblasć'] = '619';

        return $regions;
    }
}
