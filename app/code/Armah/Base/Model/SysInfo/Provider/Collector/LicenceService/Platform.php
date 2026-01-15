<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector\LicenceService;

use Armah\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform as RequestPlatform;
use Armah\Base\Model\SysInfo\Provider\Collector\CollectorInterface;
use Magento\Framework\App\ProductMetadataInterface;

class Platform implements CollectorInterface
{
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    public function __construct(ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    public function get(): array
    {
        return [
            RequestPlatform::NAME => 'Magento ' . $this->productMetadata->getEdition(),
            RequestPlatform::VERSION => $this->productMetadata->getVersion()
        ];
    }
}
