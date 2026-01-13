<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\CustomerAttributes;

use Armah\CheckoutCore\Model\Field;
use Magento\Customer\Model\Attribute;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

class UpdateAttributeFromField
{
    /**
     * @var UpdateAttribute
     */
    private $updateAttribute;

    public function __construct(UpdateAttribute $updateAttribute)
    {
        $this->updateAttribute = $updateAttribute;
    }

    /**
     * @param Field $field
     * @param Attribute $attribute
     * @return void
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function execute(Field $field, Attribute $attribute): void
    {
        $attribute->setData(UpdateField::FLAG_NO_FIELD_UPDATE, true);

        $this->updateAttribute->execute(
            $attribute,
            $field->isEnabled(),
            $field->isEnabled() && $field->getIsRequired(),
            UpdateAttribute::DEFAULT_WEBSITE_ID
        );
    }
}
