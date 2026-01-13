<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Entity\EntityData\Converter;

use Armah\Orderattr\Model\ResourceModel\Entity\EntityData\Converter\GetOptionLabels as GetLabelsResource;

class GetOptionLabels
{
    /**
     * @var GetLabelsResource
     */
    private $getLabelsResource;

    /**
     * @var array
     */
    private $cachedOptionLabels;

    public function __construct(GetLabelsResource $getLabelsResource)
    {
        $this->getLabelsResource = $getLabelsResource;
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function execute(): array
    {
        if ($this->cachedOptionLabels === null) {
            $this->cachedOptionLabels = $this->getLabelsResource->execute();
        }

        return $this->cachedOptionLabels;
    }
}
