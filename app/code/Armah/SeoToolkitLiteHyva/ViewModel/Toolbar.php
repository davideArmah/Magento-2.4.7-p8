<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Seo Toolkit Core Hyva Compatibility
 */

namespace Armah\SeoToolkitLiteHyva\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Armah\SeoToolkitLite\Block\Toolbar as ToolbarBlock;

class Toolbar implements ArgumentInterface
{
    /**
     * @var ToolkitIcons
     */
    private $toolkitIcons;

    public function __construct(ToolkitIcons $toolkitIcons)
    {
        $this->toolkitIcons = $toolkitIcons;
    }

    public function getToolkitIconByStatus(string $status): string
    {
        switch ($status) {
            case ToolbarBlock::NORMAL_CLASS:
                return $this->toolkitIcons->normalHtml('', 18, 18);
            case ToolbarBlock::WARNING_CLASS:
                return $this->toolkitIcons->warningHtml('', 18, 18);
            default:
                return '';
        }
    }
}
