<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Observer\Catalog\Product;
use Magento\Framework\Event\ObserverInterface;

class View implements ObserverInterface
{

    /**
     * @var \Armah\Meta\Helper\UrlKeyHandler
     */
    protected $_helperUrl;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Armah\Meta\Helper\Data
     */
    private $data;

    public function __construct(
        \Armah\Meta\Helper\UrlKeyHandler $helperUrl,
        \Armah\Meta\Helper\Data $data,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_helperUrl = $helperUrl;
        $this->data = $data;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();

        $this->data->observeProductPage($product);

        if ($product->getNeedUpdateProductUrl()) {
            $store = $this->_storeManager->getStore($product->getStoreId());
            $this->_helperUrl->processProduct($product, $store);
        }
    }
}
