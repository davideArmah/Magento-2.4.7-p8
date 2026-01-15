<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Model;

use Armah\CheckoutDeliveryDate\Api\DeliveryInformationManagementInterface;
use Armah\CheckoutDeliveryDate\Model\ResourceModel\Delivery as DeliveryResource;
use Magento\Framework\Escaper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class DeliveryInformationManagement implements DeliveryInformationManagementInterface
{
    /**
     * @var DeliveryResource
     */
    private $deliveryResource;

    /**
     * @var DeliveryDateProvider
     */
    private $deliveryProvider;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    public function __construct(
        DeliveryResource $deliveryResource,
        DeliveryDateProvider $deliveryProvider,
        TimezoneInterface $timezone,
        Escaper $escaper
    ) {
        $this->deliveryResource = $deliveryResource;
        $this->deliveryProvider = $deliveryProvider;
        $this->timezone = $timezone;
        $this->escaper = $escaper;
    }

    /**
     * @param int $cartId
     * @param string $date
     * @param int $time
     * @param string $comment
     * @return bool
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function update($cartId, $date, $time = -1, $comment = ''): bool
    {
        $delivery = $this->deliveryProvider->findByQuoteId((int)$cartId);
        $delivery->addData([
            'date' => $this->formatDate($date),
            'time' => $time >= 0 ? $time : null,
            'comment' => ($comment) ? $this->escaper->escapeHtml($comment) : null
        ]);

        if ($delivery->getData('date') === null
            && $delivery->getData('time') === null
            && $delivery->getData('comment') === null
        ) {
            if ($delivery->getId()) {
                $this->deliveryResource->delete($delivery);
            }
        } else {
            $this->deliveryResource->save($delivery);
        }

        return true;
    }

    private function formatDate(string $date): ?string
    {
        if (!$date) {
            return null;
        }

        return (string)$this->timezone->date($date, null, false, false)->getTimestamp();
    }
}
