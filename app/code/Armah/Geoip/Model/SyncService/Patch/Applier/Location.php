<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\SyncService\Patch\Applier;

use Armah\Geoip\Api\Data\PatchTablesDataInterface;
use Armah\Geoip\Api\LocationRepositoryInterface;
use Armah\Geoip\Api\TablePatchApplierInterface;

class Location implements TablePatchApplierInterface
{
    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    public function __construct(
        LocationRepositoryInterface $locationRepository
    ) {
        $this->locationRepository = $locationRepository;
    }

    public function apply(PatchTablesDataInterface $patchData): void
    {
        $this->locationRepository->deleteByLocId($patchData->getLocationsToDelete());
        $this->locationRepository->insertMultiple($patchData->getLocationsToInsert());
    }
}
