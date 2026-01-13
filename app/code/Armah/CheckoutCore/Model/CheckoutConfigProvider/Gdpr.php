<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\CheckoutConfigProvider;

use Armah\CheckoutCore\Model\CheckoutConfigProvider\Gdpr\ConsentsProvider;
use Magento\Checkout\Model\ConfigProviderInterface;

class Gdpr implements ConfigProviderInterface
{
    public const CONFIG_KEY = 'armahOscGdprConsent';

    /**
     * @var ConsentsProvider
     */
    private $consentsProvider;

    public function __construct(
        ConsentsProvider $consentsProvider
    ) {
        $this->consentsProvider = $consentsProvider;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return [
            static::CONFIG_KEY => $this->consentsProvider->getConsentsConfig()
        ];
    }
}
