<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api;

/**
 * @api
 */
interface GuestCheckoutDataRepositoryInterface
{
    /**
     * Save Data from Frontend Checkout
     *
     * @param string|int $armahCartId
     * @param string $checkoutFormCode
     * @param string $shippingMethodCode
     * @param \Armah\Orderattr\Api\Data\EntityDataInterface $entityData
     * @throws \Magento\Framework\Exception\InputException
     *
     * @return \Armah\Orderattr\Api\Data\EntityDataInterface
     */
    public function save(
        $armahCartId,
        $checkoutFormCode,
        $shippingMethodCode,
        \Armah\Orderattr\Api\Data\EntityDataInterface $entityData
    );
}
