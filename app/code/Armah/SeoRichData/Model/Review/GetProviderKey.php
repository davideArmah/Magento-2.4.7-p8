<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Review;

use Armah\SeoRichData\Model\ConfigProvider;

/**
 * Provide provider key for detect review source.
 * supported:
 * - default (magento)
 * - yotpo
 */
class GetProviderKey
{
    public const DEFAULT_PROVIDER_KEY = 'default';
    public const YOTPO_PROVIDER_KEY = 'yotpo';

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function execute(int $storeId): string
    {
        if ($this->configProvider->isUseYotpo($storeId)) {
            $providerKey = self::YOTPO_PROVIDER_KEY;
        } else {
            $providerKey = self::DEFAULT_PROVIDER_KEY;
        }

        return $providerKey;
    }
}
