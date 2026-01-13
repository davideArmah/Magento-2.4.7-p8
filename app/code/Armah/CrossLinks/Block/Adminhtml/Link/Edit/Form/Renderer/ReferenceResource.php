<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Block\Adminhtml\Link\Edit\Form\Renderer;

use Armah\CrossLinks\Model\LinkType\LinkProcessorProvider;
use Armah\CrossLinks\Model\LinkType\Processor\LinkTypeProcessorInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;

class ReferenceResource extends Element
{
    /**
     * @var string
     */
    protected $_template = 'form/renderer/reference_resource.phtml';

    /**
     * @var Factory
     */
    protected $elementFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var LinkProcessorProvider
     */
    private $pickerProcessorProvider;

    /**
     * @var LinkTypeProcessorInterface|null
     */
    private $processor = null;

    public function __construct(
        Context $context,
        Factory $elementFactory,
        Registry $registry,
        array $data = [],
        ?LinkProcessorProvider $pickerProcessorProvider = null
    ) {
        parent::__construct($context, $data);
        $this->elementFactory = $elementFactory;
        $this->registry = $registry;
        $this->pickerProcessorProvider = $pickerProcessorProvider
            ?? ObjectManager::getInstance()->get(LinkProcessorProvider::class);
    }

    /**
     * @return string
     * @deprecated Picker processor is used instead of current logic.
     * @see createBlock
     */
    public function getCategoryPickerHtml()
    {
        return $this->getLayout()->createBlock(
            \Magento\Catalog\Block\Adminhtml\Category\Widget\Chooser::class,
            '',
            [
                'data' => [
                    'id' => $this->_element->getHtmlId() . '_category_picker',
                    'node_click_listener' => $this->getCategoryClickListenerJs(),
                    'use_massaction' => false,
                ]
            ]
        )->toHtml();
    }

    /**
     * @return string
     * @deprecated Picker processor is used instead of current logic.
     * @see createBlock
     */
    public function getProductPickerHtml()
    {
        return $this->getLayout()->createBlock(
            \Armah\CrossLinks\Block\Adminhtml\Link\Edit\Form\Renderer\ProductPicker::class,
            '',
            [
                'data' => [
                    'id' => $this->_element->getHtmlId() . '_product_picker',
                    'row_click_callback' => $this->getProductPickerRowClickCallbackJs(),
                ]
            ]
        )->toHtml();
    }

    public function getPickerProcessors(): array
    {
        return $this->pickerProcessorProvider->getLinkProcessors();
    }

    /**
     * @param string $blockClass
     * @param array $data ['data' => ['key' => 'value', ... ]]
     *
     * @return string
     */
    public function createBlock(string $blockClass, array $data): string
    {
        return $this->getLayout()->createBlock($blockClass, '', $data)->toHtml();
    }

    /**
     * Get hidden filed html, which contains resource_reference for product and category
     *
     * @return string
     */
    public function getCatalogFieldHtml()
    {
        $hidden = $this->elementFactory->create('hidden', []);
        $hidden->setClass('catalog-field')->setName('reference_resource')->setRequired(true);
        $hidden->setId($this->_element->getHtmlId() . '_catalog_field')->setForm($this->_element->getForm());
        return $hidden->getElementHtml();
    }

    /**
     * Category Tree node onClick listener js function
     *
     * @return string
     */
    public function getCategoryClickListenerJs()
    {
        //use object manager to avoid loading dependencies of parent class
        $objectManager = ObjectManager::getInstance();
        $serializer = $objectManager->create(Json::class);

        return '
            function (node, e) {
                var nodeId = node.attributes.id != "none" ? node.attributes.id : false;
                var rootIds = ' . $serializer->serialize($this->getRootIds()) . ';
                if(rootIds.indexOf(nodeId) != -1) {
                    return;
                }
                ResourceManager.setResourceValue(nodeId);
                ResourceManager.showResourceName(nodeId ? node.text : false);
            }
        ';
    }

    /**
     * Product Grid row onClick listener js function
     *
     * @return string
     */
    public function getProductPickerRowClickCallbackJs()
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

    /**
     * Getting resource of reference(Product, Category, 3d party entities)
     *
     * @return mixed
     */
    protected function getReferenceResource()
    {
        $resource = null;
        if ($this->getProcessor()) {
            $link = $this->registry->registry('current_link');
            $resource = $this->getProcessor()->getResource($link->getReferenceResource());
        }

        return $resource;
    }

    /**
     * @return null|string
     */
    public function getReferenceResourceText()
    {
        if ($resource = $this->getReferenceResource()) {
            return $resource->getData($this->getProcessor()->getResourceTextKey());
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getReferenceResourceValue()
    {
        if ($resource = $this->getReferenceResource()) {
            return $this->getReferenceResource()->getId();
        }

        return null;
    }

    /**
     * Return ids of root categories as array
     *
     * @return array
     */
    public function getRootIds()
    {
        $ids = $this->getData('root_ids');
        if ($ids === null) {
            $ids = [\Magento\Catalog\Model\Category::TREE_ROOT_ID];
            foreach ($this->_storeManager->getGroups() as $store) {
                $ids[] = $store->getRootCategoryId();
            }
            $this->setData('root_ids', $ids);
        }
        return $ids;
    }

    private function getProcessor(): ?LinkTypeProcessorInterface
    {
        if (null === $this->processor) {
            $link = $this->registry->registry('current_link');
            if ($type = $link->getReferenceType()) {
                $this->processor = $this->pickerProcessorProvider->getLinkProcessorByType((int)$type);
            }
        }

        return $this->processor;
    }
}
