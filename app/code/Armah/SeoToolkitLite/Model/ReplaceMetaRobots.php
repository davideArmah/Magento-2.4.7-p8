<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model;

use Armah\SeoToolkitLite\Helper\Config;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

class ReplaceMetaRobots
{
    public const NO_INDEX_NO_FOLLOW = 'NOINDEX,FOLLOW';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        Config $config,
        RequestInterface $request,
        Registry $registry
    ) {
        $this->config = $config;
        $this->request = $request;
        $this->registry = $registry;
    }

    public function execute(?string $metaRobots): ?string
    {
        $currentCategory = $this->registry->registry('current_category');
        $currentProduct = $this->registry->registry('current_product');
        $amtoolkitRobots = ($currentCategory && !$currentProduct) ? $currentCategory->getAmtoolkitRobots() : null;
        if ($amtoolkitRobots && $amtoolkitRobots !== RegistryConstants::DEFAULT_ROBOTS) {
            $metaRobots = $amtoolkitRobots;
        }

        if ($this->config->isNoIndexNoFollowEnabled() && $this->request->getModuleName() === 'catalogsearch') {
            $metaRobots = self::NO_INDEX_NO_FOLLOW;
        }

        return $metaRobots;
    }
}
