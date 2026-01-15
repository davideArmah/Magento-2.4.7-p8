<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Plugin\Klarna\ModuleKp\Model\Api\Request;

use Armah\CashOnDelivery\Model\Repository\PaymentFeeRepository;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\NoSuchEntityException;

class BuilderPlugin
{
    /** @var CheckoutSession */
    private $checkoutSession;

    /** @var PaymentFeeRepository */
    private $paymentFeeRepository;

    public function __construct(
        CheckoutSession $checkoutSession,
        PaymentFeeRepository $paymentFeeRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->paymentFeeRepository = $paymentFeeRepository;
    }

    /**
     * Set cash on delivery fee in Klarna totals
     *
     * @param \Klarna\Kp\Model\Api\Request\Builder $subject
     * @param array $data
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeAddOrderlines(\Klarna\Kp\Model\Api\Request\Builder $subject, $data)
    {
        try {
            $quoteId = $this->checkoutSession->getQuoteId();
            $model = $this->paymentFeeRepository->getByQuoteId($quoteId);

            $paymentFeeData = [
                [
                    'type' => 'shipping_fee',
                    'unit_price' => round($model->getAmount() * 100),
                    'quantity' => 1,
                    'name' => __('Cash On Delivery Fee'),
                    'total_amount' => round($model->getAmount() * 100)
                ]
            ];
        } catch (NoSuchEntityException $exception) {
            return [$data];
        }

        return [array_merge($paymentFeeData, $data)];
    }
}
