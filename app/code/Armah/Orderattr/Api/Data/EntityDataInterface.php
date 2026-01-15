<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api\Data;

use Armah\Orderattr\Api\Data\CheckoutEntityInterface;
use Magento\Framework\Api\CustomAttributesDataInterface;

interface EntityDataInterface extends CheckoutEntityInterface, CustomAttributesDataInterface
{

}
