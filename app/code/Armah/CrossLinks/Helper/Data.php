<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const TYPE_PRODUCT  = 'product';
    public const TYPE_CATEGORY = 'category';
    public const TYPE_CMS      = 'cms_page';

    /**
     * @param string $entity
     * @return array
     */
    public function getEntityReplacementAttributeCodes($entity = self::TYPE_PRODUCT)
    {
        if (empty($entity)) {
            return [];
        }

        $attributeCodes = (string)$this->scopeConfig->getValue(
            'armah_cross_links/general/' . $entity . '_replacement_attributes',
            ScopeInterface::SCOPE_STORE
        );

        return explode(',', $attributeCodes);
    }

    /**
     * @param string $entity
     * @return int
     */
    public function getEntityReplacementLimit($entity = self::TYPE_PRODUCT)
    {
        return (int)$this->scopeConfig->getValue(
            'armah_cross_links/general/' . $entity . '_replacement_limit',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->scopeConfig->isSetFlag(
            'armah_cross_links/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isActiveForFaq()
    {
        return $this->scopeConfig->isSetFlag(
            'armah_cross_links/faq/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function getFaqReplacementLimit()
    {
        return (int)$this->scopeConfig->getValue(
            'armah_cross_links/faq/replacement_limit',
            ScopeInterface::SCOPE_STORE
        ) ?: 1;
    }

    /**
     * @return bool
     */
    public function isActiveForBlog()
    {
        return $this->scopeConfig->isSetFlag(
            'armah_cross_links/blog/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return int
     */
    public function getBlogReplacementLimit()
    {
        return (int)$this->scopeConfig->getValue(
            'armah_cross_links/blog/replacement_limit',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getAdvancedRegexpr()
    {
        return $this->scopeConfig->getValue(
            'armah_cross_links/advanced/regexpr',
            ScopeInterface::SCOPE_STORE
        );
    }
}
