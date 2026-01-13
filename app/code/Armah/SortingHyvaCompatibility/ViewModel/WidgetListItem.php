<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Improved Sorting Hyva Compatibility by Armah
 */

declare(strict_types=1);

namespace Armah\SortingHyvaCompatibility\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class WidgetListItem implements ArgumentInterface
{
    public const IMAGES_ONLY_TYPE = 'images';
    public const NAMES_ONLY_TYPE = 'names';
    public const FULL_VIEW_TYPE = 'full';
}
