<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Setup\Operation;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\Field\ConfigManagement\CustomerAttributes\UpdateAttributeFromField;
use Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\UpdateConfig;
use Armah\CheckoutCore\Model\ResourceModel\Field\CollectionFactory as FieldCollectionFactory;
use Armah\CheckoutCore\Model\ResourceModel\GetCustomerAddressAttributeById;

class SyncWithCheckoutFields
{
    /**
     * @var FieldCollectionFactory
     */
    private $fieldCollectionFactory;

    /**
     * @var GetCustomerAddressAttributeById
     */
    private $getCustomerAddressAttributeById;

    /**
     * @var UpdateConfig
     */
    private $updateConfig;

    /**
     * @var UpdateAttributeFromField
     */
    private $updateAttributeFromField;

    public function __construct(
        FieldCollectionFactory $fieldCollectionFactory,
        GetCustomerAddressAttributeById $getCustomerAddressAttributeById,
        UpdateConfig $updateConfig,
        UpdateAttributeFromField $updateAttributeFromField
    ) {
        $this->fieldCollectionFactory = $fieldCollectionFactory;
        $this->getCustomerAddressAttributeById = $getCustomerAddressAttributeById;
        $this->updateConfig = $updateConfig;
        $this->updateAttributeFromField = $updateAttributeFromField;
    }

    public function execute(): void
    {
        $collection = $this->fieldCollectionFactory->create()
            ->addFieldToFilter(Field::STORE_ID, Field::DEFAULT_STORE_ID);

        /** @var Field $field */
        foreach ($collection->getItems() as $field) {
            $this->updateConfig->execute($field);

            $attribute = $this->getCustomerAddressAttributeById->execute($field->getAttributeId());
            if ($attribute) {
                $this->updateAttributeFromField->execute($field, $attribute);
            }
        }
    }
}
