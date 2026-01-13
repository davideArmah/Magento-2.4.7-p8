<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Webapi;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartManagementInterface;

/**
 * Replaces a "%armah_cart_id%" value with the current authenticated customer's cart
 */

class ParamOverriderArmahCartId extends \Magento\Quote\Model\Webapi\ParamOverriderCartId
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        UserContextInterface $userContext,
        CartManagementInterface $cartManagement,
        RequestInterface $request
    ) {
        $this->request = $request;
        parent::__construct($userContext, $cartManagement);
    }

    public function getOverriddenValue()
    {
        try {
            return parent::getOverriddenValue();
        } catch (NoSuchEntityException $e) {
            $jsonContent = json_decode($this->request->getContent(), true);

            if (isset($jsonContent['armahCartId'])) {
                return $jsonContent['armahCartId'];
            }

            throw $e;
        }
    }
}
