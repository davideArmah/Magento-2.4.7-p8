<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkType\Processor;

use Armah\CrossLinks\Model\Link;
use Armah\CrossLinks\Model\Source\ReferenceType;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Block\Adminhtml\Category\Widget\Chooser;
use Magento\Catalog\Model\Category;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

class CategoryLinkProcessor implements LinkTypeProcessorInterface
{
    /**
     * @var array
     */
    private $rootIds;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Link
     */
    private $link;

    /**
     * @var Json
     */
    private $serializer;

    public function __construct(
        StoreManagerInterface $storeManager,
        Link $link,
        Json $serializer
    ) {
        $this->storeManager = $storeManager;
        $this->link = $link;
        $this->serializer = $serializer;
    }

    public function getTypeCode(): int
    {
        return ReferenceType::REFERENCE_TYPE_CATEGORY;
    }

    public function getStyleClass(): string
    {
        return 'control-category-picker';
    }

    public function getBlockClass(): string
    {
        return Chooser::class;
    }

    public function getPickerBlockData(): array
    {
        return [
            'data' => [
                'id' => 'reference_resource_category_picker',
                'node_click_listener' => $this->getCategoryClickListenerJs(),
                'use_massaction' => false,
            ]
        ];
    }

    public function getResource(string $referenceResource): ?CategoryInterface
    {
        return $this->link->getCategory($referenceResource);
    }

    public function getLinkUrl(string $referenceResource): string
    {
        return $this->link->getCategoryUrl($referenceResource);
    }

    public function getResourceTextKey(): string
    {
        return 'name';
    }

    private function getCategoryClickListenerJs(): string
    {
        return '
            function (node, e) {
                var nodeId = node.attributes.id != "none" ? node.attributes.id : false;
                var rootIds = ' . $this->serializer->serialize($this->getRootIds()) . ';
                if(rootIds.indexOf(nodeId) != -1) {
                    return;
                }
                ResourceManager.setResourceValue(nodeId);
                ResourceManager.showResourceName(nodeId ? node.text : false);
            }
        ';
    }

    /**
     * @return array ['category_id', ...]
     */
    private function getRootIds(): array
    {
        if (null === $this->rootIds) {
            $ids = [Category::TREE_ROOT_ID];
            foreach ($this->storeManager->getGroups() as $store) {
                $ids[] = $store->getRootCategoryId();
            }
            $this->rootIds = $ids;
        }

        return $this->rootIds;
    }
}
