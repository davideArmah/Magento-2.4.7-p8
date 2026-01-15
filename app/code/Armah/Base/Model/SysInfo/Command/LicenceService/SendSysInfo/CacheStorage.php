<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Command\LicenceService\SendSysInfo;

use Armah\Base\Model\FlagRepository;
use Armah\Base\Model\InstanceHash\InstanceHashFactory;
use Armah\Base\Model\InstanceHash\Repository;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;

class CacheStorage
{
    /**
     * @var Repository
     */
    private $instanceHashRepository;

    /**
     * @var InstanceHashFactory
     */
    private $instanceHashFactory;

    public function __construct(
        ?FlagRepository $flagRepository = null, //@deprecated
        ?Repository $instanceHashRepository = null,
        ?InstanceHashFactory $instanceHashFactory = null
    ) {
        $this->instanceHashRepository = $instanceHashRepository
            ?? ObjectManager::getInstance()->get(Repository::class);
        $this->instanceHashFactory = $instanceHashFactory
            ?? ObjectManager::getInstance()->get(InstanceHashFactory::class);
    }

    public function get(string $identifier): ?string
    {
        try {
            return $this->instanceHashRepository->get($identifier)->getValue();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function set(string $identifier, string $value): bool
    {
        $instanceHash = $this->instanceHashFactory->create();
        $instanceHash->setCode($identifier);
        $instanceHash->setValue($value);
        $this->instanceHashRepository->save($instanceHash);

        return true;
    }
}
