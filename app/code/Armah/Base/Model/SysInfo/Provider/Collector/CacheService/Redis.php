<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector\CacheService;

use Armah\Base\Model\SysInfo\Provider\Collector\CacheService\Info\CacheInfoInterface;
use Armah\Base\Model\SysInfo\Provider\Collector\CacheService\Info\CacheInfoInterfaceFactory;
use Armah\Base\Model\SysInfo\Provider\Collector\CacheService\Redis\RedisTypesResolver;
use Armah\Base\Model\SysInfo\Provider\Collector\CollectorInterface;

class Redis implements CollectorInterface
{
    private const CACHE_NAME = 'Redis';

    /**
     * @var RedisTypesResolver
     */
    private $redisTypesResolver;

    /**
     * @var CacheInfoInterfaceFactory
     */
    private $cacheInfoFactory;

    public function __construct(
        CacheInfoInterfaceFactory $cacheInfoFactory,
        RedisTypesResolver $redisTypesResolver
    ) {
        $this->cacheInfoFactory = $cacheInfoFactory;
        $this->redisTypesResolver = $redisTypesResolver;
    }

    public function get(): CacheInfoInterface
    {
        $enabledRedisTypes = $this->redisTypesResolver->get();

        $cacheInfo = $this->cacheInfoFactory->create();
        $cacheInfo->setName($this->getName());
        $cacheInfo->setStatus($this->resolveStatus($enabledRedisTypes));
        $cacheInfo->setAdditionalInfo($this->resolveAdditionalInfo($enabledRedisTypes));

        return $cacheInfo;
    }

    private function getName(): string
    {
        return self::CACHE_NAME;
    }

    private function resolveStatus(array $enabledRedisTypes): string
    {
        return !empty($enabledRedisTypes) ? (string)__('Active') : (string)__('Inactive');
    }

    private function resolveAdditionalInfo(array $enabledRedisTypes): string
    {
        return !empty($enabledRedisTypes) ? implode(', ', $enabledRedisTypes) : '';
    }
}
