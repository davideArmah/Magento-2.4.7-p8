<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Helper;

use Armah\Base\Model\Serializer;
use Armah\Sorting\Model\Elasticsearch\IsElasticSort;
use Magento\CatalogInventory\Model\Configuration;
use Magento\Store\Model\ScopeInterface;

/**
 * @deprecated Use config provider.
 * @see \Armah\Sorting\Model\ConfigProvider
 * @see \Armah\Sorting\Model\Method\IsMethodDisabledByConfig
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const CONFIG_SORT_ORDER = 'general/sort_order';

    public const SEARCH_SORTING = 'armahsorting_search';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var IsElasticSort
     */
    private $isElasticSort;

    public function __construct(
        \Armah\Base\Model\Serializer $serializer,
        \Magento\Framework\App\Helper\Context $context,
        IsElasticSort $isElasticSort
    ) {
        parent::__construct($context);
        $this->serializer = $serializer;
        $this->isElasticSort = $isElasticSort;
    }

    /**
     * Get config value for Store
     *
     * @param string  $path
     * @param null|string|bool|int|\Magento\Store\Model\Store $store
     *
     * @return mixed
     */
    public function getScopeValue($path, $store = null)
    {
        return $this->scopeConfig->getValue(
            'armahsorting/' . $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @deprecated
     *
     * Is Sorting Method Disabled
     *
     * @param string $methodCode
     * @param int|null $storeId
     * @return bool
     */
    public function isMethodDisabled($methodCode, $storeId = null)
    {
        $result = false;
        $disabledMethods = $this->getScopeValue('general/disable_methods', $storeId);
        if ($disabledMethods && !empty($disabledMethods)) {
            $disabledMethods = explode(',', $disabledMethods);
            foreach ($disabledMethods as $disabledCode) {
                if (trim($disabledCode) == $methodCode) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Getting default sorting on search pages
     *
     * @return array
     */
    public function getSearchSorting()
    {
        $defaultSorting = [];
        foreach (['search_1', 'search_2', 'search_3'] as $path) {
            if ($sort = $this->getScopeValue('default_sorting/' . $path)) {
                $defaultSorting[] = $sort;
            }
        }

        return $defaultSorting;
    }

    /**
     * @deprecated
     * @see \Armah\Sorting\Model\ConfigProvider::isYotpoReviewsEnabled
     *
     * @return bool
     */
    public function isYotpoEnabled()
    {
        return $this->getScopeValue('rating_summary/yotpo')
            && $this->_moduleManager->isEnabled('Armah_Yotpo')
            && $this->_moduleManager->isEnabled('Yotpo_Yotpo');
    }

    /**
     * @param null|int $storeId
     * @return int
     */
    public function getQtyOutStock($storeId = null)
    {
        return (int)$this->scopeConfig->getValue(
            Configuration::XML_PATH_MIN_QTY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return array
     * @deprecated
     * @see \Armah\Sorting\Model\ConfigProvider::getSortOrder
     */
    public function getSortOrder(): array
    {
        $value = $this->getScopeValue(self::CONFIG_SORT_ORDER);
        if ($value) {
            $value = $this->serializer->unserialize($value);
        }
        if (!$value) {
            $value = [];
        }

        return $value;
    }

    /**
     * @param null|int $store
     *
     * @return array
     */
    public function getCategorySorting($store = null)
    {
        $defaultSorting = [];
        foreach (['category_1', 'category_2', 'category_3'] as $path) {
            if ($sort = $this->getScopeValue('default_sorting/' . $path, $store)) {
                $defaultSorting[] = $sort;
            }
        }

        return $defaultSorting;
    }

    /**
     * @deprecated
     *
     * @param bool $skipStoreCheck
     * @return bool
     */
    public function isElasticSort(bool $skipStoreCheck = false)
    {
        return $this->isElasticSort->execute($skipStoreCheck);
    }

    /**
     * @deprecated
     * @see GetAttributeCodesForSorting
     * @return array
     */
    public function getArmahAttributesCodes()
    {
        $result = [
            'created_at',
            $this->getScopeValue('bestsellers/best_attr'),
            $this->getScopeValue('most_viewed/viewed_attr'),
            $this->getScopeValue('new/new_attr')
        ];

        return array_filter($result);
    }

    /**
     * @param null|int $storeId
     * @return int
     */
    public function getNonImageLast($storeId = null)
    {
        return (int) $this->getScopeValue('general/no_image_last', $storeId);
    }

    /**
     * @param null|int $storeId
     * @return int
     */
    public function getOutOfStockLast($storeId = null)
    {
        return (int) $this->getScopeValue('general/out_of_stock_last', $storeId);
    }

    /**
     * @param null|int $storeId
     * @return bool
     */
    public function isOutOfStockByQty($storeId = null)
    {
        return (bool) $this->getScopeValue('general/out_of_stock_qty', $storeId);
    }
}
