<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Entity\Adapter\Order\Plugin\Api\OrderRepository;

use Armah\Orderattr\Model\Entity\Adapter\Order\Adapter;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class DeleteOrderAttributeEntity
{
    /**
     * @var Adapter
     */
    private $orderAdapter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Adapter $orderAdapter, LoggerInterface $logger)
    {
        $this->orderAdapter = $orderAdapter;
        $this->logger = $logger;
    }

    public function afterDelete(
        OrderRepositoryInterface $subject,
        bool $result,
        OrderInterface $order
    ): bool {
        try {
            $this->orderAdapter->deleteAttributeEntityByOrder($order);
        } catch (\Exception $e) {
            $this->logger->error($e);
        }

        return $result;
    }
}
