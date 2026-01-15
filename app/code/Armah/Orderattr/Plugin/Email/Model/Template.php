<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Plugin\Email\Model;

class Template
{
    public const IS_SALES_EMAIL_VARIABLE = '{{var order.increment_id}}';

    /**
     * @var \Armah\Orderattr\Model\ResourceModel\Attribute\CollectionFactory
     */
    private $collectionFactory;

    public function __construct(\Armah\Orderattr\Model\ResourceModel\Attribute\CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Plugin for adding attributes to marketing order emails to Insert Variable.
     *
     * @param \Magento\Framework\Mail\TemplateInterface|\Magento\Email\Model\Template $subject
     * @param array $result
     * @param bool $withGroup
     *
     * @return array $result
     */
    public function afterGetVariablesOptionArray($subject, $result, $withGroup = false)
    {
        if (!empty($result)) {
            if ($withGroup) {
                $value = &$result['value'];
            } else {
                $value = &$result;
            }
        } else {
            return $result;
        }

        if (!$this->isSalesEmail($value)) {
            return $result;
        }

        /** @var \Armah\Orderattr\Model\ResourceModel\Attribute\Collection $attributeCollection */
        $attributeCollection = $this->collectionFactory->create();
        $attributeCollection->addFieldToSelect('attribute_code');
        $attributeCollection->addFieldToSelect('frontend_label');

        foreach ($attributeCollection->getData() as $attribute) {
            $value[] = [
                'label' => 'Armah Order Attribute: ' . $attribute['frontend_label'],
                'value' => '{{var order.' . $attribute['attribute_code'] . '}}'
            ];
        }

        return $result;
    }

    /**
     * @param array $result
     *
     * @return bool
     */
    private function isSalesEmail($result)
    {
        foreach ($result as $variable) {
            if ($variable['value'] === self::IS_SALES_EMAIL_VARIABLE) {
                return true;
            }
        }

        return false;
    }
}
