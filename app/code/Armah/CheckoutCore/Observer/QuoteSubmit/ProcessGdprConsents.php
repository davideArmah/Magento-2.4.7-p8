<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\QuoteSubmit;

use Armah\Base\Model\Serializer;
use Armah\CheckoutCore\Model\Gdpr\ConsentsProcessor;
use Armah\CheckoutCore\Model\ModuleEnable;
use Armah\Gdpr\Model\Consent\RegistryConstants;
use Armah\Gdpr\Observer\Checkout\ConsentRegistry;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Event 'sales_order_place_after'
 */
class ProcessGdprConsents implements ObserverInterface
{
    /**
     * @var ConsentsProcessor
     */
    private $consentsProcessor;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    public function __construct(
        ConsentsProcessor $consentsProcessor,
        Serializer $serializer,
        ObjectManagerInterface $objectManager,
        ModuleEnable $moduleEnable
    ) {
        $this->consentsProcessor = $consentsProcessor;
        $this->serializer = $serializer;
        $this->objectManager = $objectManager;
        $this->moduleEnable = $moduleEnable;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer): void
    {
        if (!$this->moduleEnable->isGdprEnable()) {
            return;
        }

        /** @var OrderInterface $order */
        $order = $observer->getData('order');
        $additionalInfo = $order->getPayment()->getAdditionalInformation();
        /** @var ConsentRegistry $consentRegistry */
        $consentRegistry = $this->objectManager->get(ConsentRegistry::class);
        $consentsData = $consentRegistry->getConsents();

        if (isset($additionalInfo[RegistryConstants::CONSENTS]) && empty($consentsData)) {
            $consentsData = $this->serializer->unserialize($additionalInfo[RegistryConstants::CONSENTS]);
        }

        if (!empty($consentsData)) {
            $this->consentsProcessor->process($order, $consentsData);
        }
    }
}
