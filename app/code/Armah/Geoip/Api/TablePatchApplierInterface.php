<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Api;

use Armah\Geoip\Api\Data\PatchTablesDataInterface;

interface TablePatchApplierInterface
{
    public function apply(PatchTablesDataInterface $patchData): void;
}
