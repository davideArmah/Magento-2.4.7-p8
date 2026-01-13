<?php

declare(strict_types=1);

namespace Hyva\StripeIntegrationPayments\ViewModel;

use Magento\Framework\Module\Manager;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Checkout implements ArgumentInterface
{
    public function __construct(
        private Manager $moduleManager,
    ) {}

    public function hasHyvaCheckoutInstalled(): bool
    {
        return $this->moduleManager->isEnabled('Hyva_Checkout');
    }
}
