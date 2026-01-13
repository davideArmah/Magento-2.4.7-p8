<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\SyncService\Patch;

use Armah\Geoip\Api\Data\PatchTablesDataInterface;
use Armah\Geoip\Api\TablePatchApplierInterface;

class ApplierComposite implements TablePatchApplierInterface
{
    /**
     * @var TablePatchApplierInterface[]
     */
    private $appliersPool;

    public function __construct(
        array $appliersPool = []
    ) {
        $this->appliersPool = $appliersPool;
    }

    public function apply(PatchTablesDataInterface $patchData): void
    {
        foreach ($this->appliersPool as $applier) {
            $applier->apply($patchData);
        }
    }
}
