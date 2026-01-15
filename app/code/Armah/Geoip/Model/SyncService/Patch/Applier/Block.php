<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\SyncService\Patch\Applier;

use Armah\Geoip\Api\BlockRepositoryInterface;
use Armah\Geoip\Api\Data\PatchTablesDataInterface;
use Armah\Geoip\Api\TablePatchApplierInterface;

class Block implements TablePatchApplierInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    public function __construct(
        BlockRepositoryInterface $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
    }

    public function apply(PatchTablesDataInterface $patchData): void
    {
        $this->blockRepository->deleteByStartAndEndIpNum($patchData->getBlocksToDelete());
        $this->blockRepository->insertMultiple($patchData->getBlocksToInsert());
    }
}
