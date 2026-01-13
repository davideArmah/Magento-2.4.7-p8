<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Observer\Payment\Model\Method;

use Armah\CashOnDelivery\Model\PaymentValidator;
use Magento\Framework\Event\ObserverInterface;

class CheckAvailable implements ObserverInterface
{
    /**
     * @var PaymentValidator
     */
    private $paymentValidator;

    public function __construct(PaymentValidator $paymentValidator)
    {
        $this->paymentValidator = $paymentValidator;
    }

    /**
     * @inheritdoc
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $methodInstance = $observer->getMethodInstance();

        if ($methodInstance instanceof \Magento\OfflinePayments\Model\Cashondelivery) {
            /** @var \Magento\Quote\Model\Quote $quote */
            if ($quote = $observer->getQuote()) {
                $result = $observer->getResult();
                $result->setIsAvailable(
                    $this->paymentValidator->validateBasedOnShipping($quote)
                    && $this->paymentValidator->validateBaseOnPostalCode($quote)
                );
            }
        }
    }
}
