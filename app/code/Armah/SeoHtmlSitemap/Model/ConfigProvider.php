<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package HTML Sitemap for Magento 2
 */

namespace Armah\SeoHtmlSitemap\Model;

use Armah\Base\Model\ConfigProviderAbstract;
use Armah\Base\Model\Serializer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider extends ConfigProviderAbstract
{
    public const CONFIG_SORT_ORDER = 'general/sort_order';

    /**
     * @var string
     */
    protected $pathPrefix = 'arseohtmlsitemap/';

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Serializer $serializer
    ) {
        parent::__construct($scopeConfig);
        $this->serializer = $serializer;
    }

    public function getSortOrder(?int $scopeId = null): array
    {
        return $this->serializer->unserialize(
            $this->getValue(self::CONFIG_SORT_ORDER, $scopeId, ScopeInterface::SCOPE_WEBSITES)
        );
    }
}
