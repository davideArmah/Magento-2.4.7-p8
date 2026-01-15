<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Plugin\Framework\View\Page\Config;

use Armah\SeoToolkitLite\Model\ReplaceMetaRobots as ReplaceRobots;
use Magento\Framework\View\Page\Config as NativeConfig;

class ReplaceMetaRobots
{
    /**
     * @var ReplaceRobots
     */
    private $replaceMetaRobots;

    public function __construct(ReplaceRobots $replaceMetaRobots)
    {
        $this->replaceMetaRobots = $replaceMetaRobots;
    }

    public function afterGetRobots(
        NativeConfig $subject,
        ?string $metaRobots
    ): ?string {
        return $this->replaceMetaRobots->execute($metaRobots);
    }
}
