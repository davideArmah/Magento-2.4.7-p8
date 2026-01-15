<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class EnableGuestCheckoutLogin extends Field
{
    public function render(AbstractElement $element): string
    {
        // if the original value is null,
        // that means that config doesn't exist on this version of Magento (< v2.4.5p3)
        if ($element->getValue() === null) {
            return '';
        }

        return parent::render($element);
    }
}
