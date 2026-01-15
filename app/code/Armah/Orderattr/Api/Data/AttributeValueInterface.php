<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api\Data;

use Magento\Framework\Api\AttributeInterface;

interface AttributeValueInterface extends AttributeInterface
{
    /**
     * @param string|null $label
     * @return $this
     */
    public function setLabel(?string $label);

    /**
     * @return string|null
     */
    public function getLabel(): ?string;
}
