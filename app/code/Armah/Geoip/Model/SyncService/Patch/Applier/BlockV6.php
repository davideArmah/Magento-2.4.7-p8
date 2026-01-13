<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\SyncService\Patch\Applier;

use Armah\Geoip\Api\BlockV6RepositoryInterface;
use Armah\Geoip\Api\Data\PatchTablesDataInterface;
use Armah\Geoip\Api\TablePatchApplierInterface;

class BlockV6 implements TablePatchApplierInterface
{
    /**
     * @var BlockV6RepositoryInterface
     */
    private $blockV6Repository;

    public function __construct(
        BlockV6RepositoryInterface $blockV6Repository
    ) {
        $this->blockV6Repository = $blockV6Repository;
    }

    public function apply(PatchTablesDataInterface $patchData): void
    {
        $this->blockV6Repository->deleteByStartAndEndIpNum($patchData->getBlocksV6ToDelete());
        $this->blockV6Repository->insertMultiple($patchData->getBlocksV6ToInsert());
    }
}
