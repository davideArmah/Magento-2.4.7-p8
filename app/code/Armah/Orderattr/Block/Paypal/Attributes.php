<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Paypal;

use Armah\Orderattr\Model\Attribute\Frontend\CollectionProvider;
use Armah\Orderattr\Model\Attribute\InputType\InputTypeProvider;
use Magento\Checkout\Model\CompositeConfigProvider;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Attributes extends Template
{
    /**
     * @var null|string
     */
    private $attributesJsLayout;

    /**
     * @var string
     */
    protected $_template = 'Armah_Orderattr::paypal/attributes.phtml';

    /**
     * @var CollectionProvider
     */
    private $collectionProvider;

    /**
     * @var InputTypeProvider
     */
    private $inputTypeProvider;

    /**
     * @var CompositeConfigProvider
     */
    private $checkoutConfigProvider;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        CollectionProvider $collectionProvider,
        InputTypeProvider $inputTypeProvider,
        CompositeConfigProvider $checkoutConfigProvider,
        SerializerInterface $serializer,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionProvider = $collectionProvider;
        $this->inputTypeProvider = $inputTypeProvider;
        $this->checkoutConfigProvider = $checkoutConfigProvider;
        $this->serializer = $serializer;
    }

    public function getJsLayout(): string
    {
        if ($this->attributesJsLayout === null) {
            $this->attributesJsLayout = [];
            if ($attributes = $this->collectionProvider->getAttributes()) {
                $this->attributesJsLayout['components'] = [
                    'arorder_attributes_fields' => [
                        'component' => 'Armah_Orderattr/js/view/order-attributes',
                        'name' => 'arorder_attributes_fields',
                        'scope' => 'arorder_attributes_fields',
                        'arScope' => 'arorder_attributes_fields',
                        'template' => 'Armah_Orderattr/order-attributes-div',
                        'children' => $this->inputTypeProvider->getFrontendElements(
                            $attributes,
                            'armahCheckoutProvider',
                            'arorder_attributes_fields'
                        )
                    ]
                ];
            }
            $this->attributesJsLayout['components']['armahCheckoutProvider'] = ['component' => 'uiComponent'];
        }

        return $this->serializer->serialize($this->attributesJsLayout);
    }

    public function getCheckoutConfig(): string
    {
        return $this->serializer->serialize($this->checkoutConfigProvider->getConfig());
    }
}
