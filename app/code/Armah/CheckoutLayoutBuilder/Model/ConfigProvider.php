<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Layout Builder for Magento 2 (System)
 */

namespace Armah\CheckoutLayoutBuilder\Model;

use Armah\Base\Model\ConfigProviderAbstract;
use Armah\Base\Model\Serializer;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider extends ConfigProviderAbstract
{
    /**
     * Path Prefix For Config
     */
    public const PATH_PREFIX = 'armah_checkout/';

    public const LAYOUT_BUILDER_BLOCK = 'layout_builder/';
    public const DESIGN_BLOCK = 'design/';

    public const FIELD_FRONTEND_LAYOUT_CONFIG = 'frontend_layout_config';
    public const FIELD_LAYOUT_BUILDER_CONFIG = 'layout_builder_config';
    public const FIELD_CHECKOUT_DESIGN = 'checkout_design';
    public const FIELD_CHECKOUT_LAYOUT = 'layout';
    public const FIELD_CHECKOUT_LAYOUT_MODERN = 'layout_modern';

    /**
     * xpath prefix of module (section)
     *
     * @var string
     */
    protected $pathPrefix = self::PATH_PREFIX;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(ScopeConfigInterface $scopeConfig, Serializer $serializer)
    {
        parent::__construct($scopeConfig);
        $this->serializer = $serializer;
    }

    /**
     * @param ?int $store
     * @return array
     */
    public function getCheckoutBlocksConfig(?int $store = null): array
    {
        $value = $this->getValue(self::LAYOUT_BUILDER_BLOCK . self::FIELD_FRONTEND_LAYOUT_CONFIG, $store);

        return $this->serializer->unserialize($value);
    }
}
