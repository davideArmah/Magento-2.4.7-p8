<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkType\Processor;

use Armah\CrossLinks\Block\Adminhtml\Link\Edit\Form\Renderer\ProductPicker;
use Armah\CrossLinks\Model\Link;
use Armah\CrossLinks\Model\Source\ReferenceType;
use Magento\Catalog\Api\Data\ProductInterface;

class ProductLinkProcessor implements LinkTypeProcessorInterface
{
    /**
     * @var Link
     */
    private $link;

    public function __construct(
        Link $link
    ) {
        $this->link = $link;
    }

    public function getTypeCode(): int
    {
        return ReferenceType::REFERENCE_TYPE_PRODUCT;
    }

    public function getStyleClass(): string
    {
        return 'control-product-picker';
    }

    public function getBlockClass(): string
    {
        return ProductPicker::class;
    }

    public function getPickerBlockData(): array
    {
        return [
            'data' => [
                'id' => 'reference_resource_product_picker',
                'row_click_callback' => $this->getPickerRowClickCallbackJs(),
                ]
            ];
    }

    public function getResource(string $referenceResource): ?ProductInterface
    {
        return $this->link->getProduct($referenceResource);
    }

    public function getLinkUrl(string $referenceResource): string
    {
        return $this->link->getProductUrl($referenceResource);
    }

    public function getResourceTextKey(): string
    {
        return 'name';
    }

    private function getPickerRowClickCallbackJs(): string
    {
        return '
            function (grid, event) {
                var trElement   = Event.findElement(event, "tr");
                for (var i = 0; i < trElement.childNodes.length; i++) {
                    if (typeof trElement.childNodes[i].classList != "undefined") {
                        if (trElement.childNodes[i].classList.contains("col-entity_id")) {
                            ResourceManager.setResourceValue(trElement.childNodes[i].innerText);
                        }
                        if (trElement.childNodes[i].classList.contains("col-name")) {
                            ResourceManager.showResourceName(trElement.childNodes[i].innerText);
                        }
                    }
                }
            }
        ';
    }
}
