<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\CheckoutConfigProvider\Gdpr;

use Armah\CheckoutCore\Model\Config\Source\Gdpr\CheckboxLocation;
use Armah\CheckoutCore\Model\ModuleEnable;
use Armah\Gdpr\Model\Consent\DataProvider\CheckoutDataProvider;
use Magento\Framework\ObjectManagerInterface;

class ConsentsProvider
{
    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var CheckboxLocation
     */
    private $checkboxLocation;

    /**
     * @var array
     */
    private $consentsConfig;

    public function __construct(
        ModuleEnable $moduleEnable,
        ObjectManagerInterface $objectManager,
        CheckboxLocation $checkboxLocation
    ) {
        $this->moduleEnable = $moduleEnable;
        $this->objectManager = $objectManager;
        $this->checkboxLocation = $checkboxLocation;
    }

    /**
     * @return array
     */
    public function getConsentsConfig(): array
    {
        if (!$this->moduleEnable->isGdprEnable()) {
            return [];
        }

        if ($this->consentsConfig === null) {
            $consentsConfig = [];
            $gdprProvider = $this->objectManager->get(CheckoutDataProvider::class);

            foreach ($this->checkboxLocation->toArray() as $location) {
                $consents = $gdprProvider->getData($location);
                if (!empty($consents['consents'])) {
                    $consentsConfig[$location] = $consents;
                }
            }

            $this->consentsConfig = $consentsConfig;
        }

        return $this->consentsConfig;
    }
}
