<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\AdditionalFieldsManagementInterface;
use Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface;
use Armah\CheckoutCore\Model\AdditionalFieldsFactory;

class AdditionalFieldsManagement implements AdditionalFieldsManagementInterface
{
    /**
     * @var ResourceModel\AdditionalFields
     */
    private $fieldsResource;

    /**
     * @var AdditionalFieldsFactory
     */
    private $fieldsFactory;

    /**
     * @var AdditionalFields[]
     */
    protected $storage = [];

    public function __construct(
        ResourceModel\AdditionalFields $fieldsResource,
        AdditionalFieldsFactory $fieldsFactory
    ) {
        $this->fieldsResource = $fieldsResource;
        $this->fieldsFactory = $fieldsFactory;
    }

    /**
     * @inheritdoc
     */
    public function save($cartId, $fields)
    {
        $model = $this->getByQuoteId($cartId)->addData($fields->getData());
        $this->fieldsResource->save($model);
        $this->storage[$cartId] = $model;
        return true;
    }

    /**
     * @param int $quoteId
     *
     * @return AdditionalFields
     */
    public function getByQuoteId($quoteId)
    {
        if (!isset($this->storage[$quoteId])) {
            /** @var AdditionalFields $fields */
            $fields = $this->fieldsFactory->create();
            $this->fieldsResource->load($fields, $quoteId, AdditionalFieldsInterface::QUOTE_ID);
            $fields->setQuoteId($quoteId);
            $this->storage[$quoteId] = $fields;
        }

        return $this->storage[$quoteId];
    }
}
