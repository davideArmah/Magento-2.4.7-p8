<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Sales\Admin\Order\Address;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields\Collection;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields\CollectionFactory;

class Form
{
    /**
     * @var CollectionFactory
     */
    private $orderCustomFieldsCollection;

    public function __construct(
        CollectionFactory $orderCustomFieldsCollection
    ) {
        $this->orderCustomFieldsCollection = $orderCustomFieldsCollection;
    }

    /**
     * @param \Magento\Sales\Block\Adminhtml\Order\Address\Form $subject
     * @param array $formValues
     *
     * @return array
     */
    public function afterGetFormValues(\Magento\Sales\Block\Adminhtml\Order\Address\Form $subject, $formValues)
    {
        foreach (\Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY as $attributeCode) {
            /** @var Collection $orderCustomFieldsCollection */
            $orderCustomFieldsCollection = $this->orderCustomFieldsCollection->create();
            $orderCustomFieldsCollection->addFieldByOrderIdAndCustomField(
                $formValues['parent_id'],
                $attributeCode
            );
            $orderCustomFieldsData = $orderCustomFieldsCollection->getFirstItem()->getData();

            if ($orderCustomFieldsData) {
                $formValues[$orderCustomFieldsData[OrderCustomFieldsInterface::NAME]] =
                    $orderCustomFieldsData[$formValues['address_type'] . '_value'];
            }
        }

        return $formValues;
    }
}
