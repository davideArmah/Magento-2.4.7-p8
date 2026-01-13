<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Entity\EntityData;

use Armah\Orderattr\Api\Data\AttributeValueInterface;

class AttributeValue extends \Magento\Framework\Api\AttributeValue implements AttributeValueInterface
{
    public const LABEL = 'label';

    public function setLabel(?string $label)
    {
        return $this->setData(self::LABEL, $label);
    }

    public function getLabel(): ?string
    {
        return $this->_get(self::LABEL);
    }
}
