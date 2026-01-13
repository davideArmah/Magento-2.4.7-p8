<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml\Backend;

use Armah\Base\Model\ArmahMenu\Frontend\ItemsProvider;
use Armah\Base\Model\Serializer;
use Magento\Backend\Block\Template;

class ArmahMenu extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Armah_Base::menu/submenu.phtml';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var ItemsProvider
     */
    private $itemsProvider;

    public function __construct(
        Template\Context $context,
        Serializer $serializer,
        ItemsProvider $itemsProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->serializer = $serializer;
        $this->itemsProvider = $itemsProvider;
    }

    public function getMenuItemsJson(): string
    {
        $items = $this->itemsProvider->getItems();

        return $this->serializer->serialize($items);
    }
}
