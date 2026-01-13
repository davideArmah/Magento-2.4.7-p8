<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\SysInfo;

use Armah\Base\Model\SysInfo\RegisteredInstanceRepository;

class InstanceIdProvider
{
    /**
     * @var RegisteredInstanceRepository
     */
    private $registeredInstanceRepository;

    /**
     * @var string|null
     */
    private $instanceId;

    public function __construct(
        RegisteredInstanceRepository $registeredInstanceRepository
    ) {
        $this->registeredInstanceRepository = $registeredInstanceRepository;
    }

    public function getInstanceId(): ?string
    {
        if ($this->instanceId === null) {
            $registeredInstance = $this->registeredInstanceRepository->get()->getCurrentInstance();
            $this->instanceId = $registeredInstance
                ? $registeredInstance->getSystemInstanceKey()
                : null;
        }

        return $this->instanceId;
    }

    public function _resetState(): void
    {
        $this->instanceId = null;
    }
}
