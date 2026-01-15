<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Redirect;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;
use Armah\SeoToolkitLite\Model\ResourceModel\Redirect\CollectionFactory;
use Magento\Framework\Data\Collection;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

/**
 * @see \Armah\SeoToolkitLite\Test\Unit\Model\Redirect\RedirectGetterTest
 */
class RedirectGetter
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(
        CollectionFactory $collectionFactory,
        StoreManager $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $path
     * @return RedirectInterface|null
     */
    public function getRedirect(string $path): ?RedirectInterface
    {
        $collection = $this->getCollection();
        $resultRedirect = null;
        foreach ($collection as $redirect) {
            if ($this->isValidRedirect($redirect->getRequestPath(), $path)) {
                $resultRedirect = $redirect;
                break;
            }
        }

        return $resultRedirect;
    }

    private function isValidRedirect(string $requestPath, string $path): bool
    {
        $requestPath = trim($requestPath, '/');
        $path = trim($path, '/');
        if (strpos($requestPath, '*') !== false) {
            $requestPath = str_replace(['/', '*'], ['\/', '\w*'], $requestPath);
            $isValid = $requestPath && preg_match('/^' . $requestPath . '/', $path);
        } else {
            $isValid = $requestPath == $path;
        }

        return $isValid;
    }

    /**
     * @return \Armah\SeoToolkitLite\Model\ResourceModel\Redirect\Collection|void
     */
    private function getCollection()
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(RedirectInterface::STATUS, 1)
            ->addStoreFilter((int)$this->storeManager->getStore()->getId())
            ->setOrders([
                RedirectInterface::PRIORITY => Collection::SORT_ORDER_ASC,
                RedirectInterface::REDIRECT_ID => Collection::SORT_ORDER_ASC
            ]);
    }
}
