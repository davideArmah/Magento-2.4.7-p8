<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Gdpr;

use Armah\Gdpr\Model\Consent\RegistryConstants;
use Armah\Gdpr\Model\ConsentLogger;
use Magento\Framework\Event\ManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;

class ConsentsProcessor
{
    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ManagerInterface $eventManager,
        LoggerInterface $logger
    ) {
        $this->eventManager = $eventManager;
        $this->logger = $logger;
    }

    /**
     * @param OrderInterface $order
     * @param array $consentsData
     */
    public function process(OrderInterface $order, array $consentsData): void
    {
        $storeId = (int)$order->getStoreId();
        $customerId = (int)$order->getCustomerId();
        $email = (string)$order->getCustomerEmail();
        $consentsData = $this->groupConsentsData($consentsData);

        try {
            foreach ($consentsData as $from => $consentCodes) {
                $this->eventManager->dispatch(
                    'armah_gdpr_consent_accept',
                    [
                        RegistryConstants::CONSENTS => $consentCodes,
                        RegistryConstants::CONSENT_FROM => $from,
                        RegistryConstants::CUSTOMER_ID => $customerId,
                        RegistryConstants::STORE_ID => $storeId,
                        RegistryConstants::EMAIL => $email
                    ]
                );
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param array $consentsData
     * @return array
     */
    private function groupConsentsData(array $consentsData): array
    {
        $grouped = [];

        foreach ($consentsData as $consentCode => $consent) {
            $from = $consent['from'] ?? ConsentLogger::FROM_CHECKOUT;
            $checked = $consent['checked'] ?? $consent;
            $grouped[$from][$consentCode] = $checked;
        }

        return $grouped;
    }
}
