<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Rule;

class Rule extends \Magento\CatalogRule\Model\Rule
{
    public function clearResult(): void
    {
        $this->_productIds = null;
        $this->_conditions = null;
    }
}
