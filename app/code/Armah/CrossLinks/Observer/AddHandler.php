<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Observer;

use Magento\Framework\Event\ObserverInterface;
use Armah\CrossLinks\Helper\Data as CrossLinksHelper;

/**
 * Class AddHandler
 * @package Armah\CrossLinks\Observer
 */
class AddHandler implements ObserverInterface
{
    /**
     * @var \Magento\Catalog\Helper\Output
     */
    protected $outputHelper;

    /**
     * @var \Armah\CrossLinks\Model\ReplaceManager
     */
    protected $replaceManager;

    /**
     * AddHandler constructor.
     * @param \Magento\Catalog\Helper\Output $outputHelper
     * @param \Armah\CrossLinks\Model\ReplaceManager $replaceManager
     */
    public function __construct(
        \Magento\Catalog\Helper\Output $outputHelper,
        \Armah\CrossLinks\Model\ReplaceManager $replaceManager
    ) {
        $this->outputHelper = $outputHelper;
        $this->replaceManager = $replaceManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $product = $observer->getEvent()->getProduct();
        switch (true) {
            case !is_null($product) :
                $this->replaceManager->setEntityType(CrossLinksHelper::TYPE_PRODUCT);
                break;
            case !is_null($category) :
                $this->replaceManager->setEntityType(CrossLinksHelper::TYPE_CATEGORY);
                break;
        }
        $this->outputHelper->addHandler('productAttribute', $this->replaceManager);
        $this->outputHelper->addHandler('categoryAttribute', $this->replaceManager);
        return $this;
    }
}
