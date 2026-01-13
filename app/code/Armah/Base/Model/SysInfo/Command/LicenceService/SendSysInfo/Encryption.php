<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Command\LicenceService\SendSysInfo;

use Magento\Framework\Serialize\SerializerInterface;

class Encryption
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    public function encryptArray(array $value): string
    {
        $serializedValue = $this->serializer->serialize($value);

        return $this->encryptString($serializedValue);
    }

    public function encryptString(string $value): string
    {
        return hash('sha256', $value);
    }
}
