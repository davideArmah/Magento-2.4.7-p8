<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Style Switcher for Magento 2 (System)
 */

namespace Armah\CheckoutStyleSwitcher\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PlaceButtonLayout implements OptionSourceInterface
{
    public const PAYMENT = 'payment';
    public const SUMMARY = 'summary';
    public const FIXED_TOP = 'top';
    public const FIXED_BOTTOM = 'bottom';

    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::PAYMENT, 'label' => __('Below the Selected Payment Method')],
            ['value' => self::SUMMARY, 'label' => __('Below the Order Total')]
        ];
    }
}
