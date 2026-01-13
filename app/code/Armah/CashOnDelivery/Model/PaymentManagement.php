<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model;

use Armah\CashOnDelivery\Api\PaymentManagementInterface;
use Armah\CashOnDelivery\Model\PaymentValidator;

class PaymentManagement implements PaymentManagementInterface
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
    public function checkAvailable($postalCode)
    {
        return $this->paymentValidator->validateBaseOnPostalCode(null, $postalCode);
    }
}
