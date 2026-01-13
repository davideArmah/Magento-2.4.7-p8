<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Api;

use Armah\Base\Model\LicenceService\Api\Client\AdditionalInfo;
use Armah\Base\Model\SimpleDataObject;

class RequestFacade
{
    /**
     * @var AdditionalInfo
     */
    private $additionalInfo;

    public function __construct(
        AdditionalInfo $additionalInfo
    ) {
        $this->additionalInfo = $additionalInfo;
    }

    public function getAdditionalInfo(array $params): SimpleDataObject
    {
        return $this->additionalInfo->requestAdditionalInfo($params);
    }
}
