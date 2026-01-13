<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Api\Data;

interface ConfigInterface
{
    const CONFIG_ID = 'config_id';
    const CATEGORY_ID = 'category_id';
    const STORE_ID = 'store_id';
    const IS_CUSTOM = 'is_custom';
    const CUSTOM_URL = 'custom_url';
    const PRIORITY = 'priority';
    const CUSTOM_META_TITLE = 'custom_meta_title';
    const CUSTOM_META_KEYWORDS = 'custom_meta_keywords';
    const CUSTOM_META_DESCRIPTION = 'custom_meta_description';
    const CUSTOM_CANONICAL_URL = 'custom_canonical_url';
    const CUSTOM_ROBOTS = 'custom_robots';
    const CUSTOM_H1_TAG = 'custom_h1_tag';
    const CUSTOM_IN_PAGE_TEXT = 'custom_in_page_text';
    const CAT_META_TITLE = 'cat_meta_title';
    const CAT_META_DESCRIPTION = 'cat_meta_description';
    const CAT_META_KEYWORDS = 'cat_meta_keywords';
    const CAT_H1_TAG = 'cat_h1_tag';
    const CAT_DESCRIPTION = 'cat_description';
    const CAT_IMAGE_ALT = 'cat_image_alt';
    const CAT_IMAGE_TITLE = 'cat_image_title';
    const CAT_AFTER_PRODUCT_TEXT = 'cat_after_product_text';
    const PRODUCT_META_TITLE = 'product_meta_title';
    const PRODUCT_META_KEYWORDS = 'product_meta_keywords';
    const PRODUCT_META_DESCRIPTION = 'product_meta_description';
    const PRODUCT_H1_TAG = 'product_h1_tag';
    const PRODUCT_SHORT_DESCRIPTION = 'product_short_description';
    const PRODUCT_DESCRIPTION = 'product_description';
    const SUB_PRODUCT_META_TITLE = 'sub_product_meta_title';
    const SUB_PRODUCT_META_KEYWORDS = 'sub_product_meta_keywords';
    const SUB_PRODUCT_META_DESCRIPTION = 'sub_product_meta_description';
    const SUB_PRODUCT_H1_TAG = 'sub_product_h1_tag';
    const SUB_PRODUCT_SHORT_DESCRIPTION = 'sub_product_short_description';
    const SUB_PRODUCT_DESCRIPTION = 'sub_product_description';
    const IS_BRAND_CONFIG = 'is_brand_config';
    const BRAND_META_TITLE = 'brand_meta_title';
    const BRAND_META_DESCRIPTION = 'brand_meta_description';
    const BRAND_META_KEYWORDS = 'brand_meta_keywords';
    const BRAND_H1_TAG = 'brand_h1_tag';
    const BRAND_DESCRIPTION = 'brand_description';
    const BRAND_AFTER_PRODUCT_TEXT = 'brand_after_product_text';
    const TABLE_NAME = 'armah_meta_config';

    /**
     * @return int
     */
    public function getConfigId();

    /**
     * @param int $configId
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setConfigId($configId);

    /**
     * @return int
     */
    public function getCategoryId();

    /**
     * @param int $categoryId
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCategoryId($categoryId);

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @param int $storeId
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setStoreId($storeId);

    /**
     * @return int
     */
    public function getIsCustom();

    /**
     * @param int $isCustom
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setIsCustom($isCustom);

    /**
     * @return string|null
     */
    public function getCustomUrl();

    /**
     * @param string|null $customUrl
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomUrl($customUrl);

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @param int $priority
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setPriority($priority);

    /**
     * @return string|null
     */
    public function getCustomMetaTitle();

    /**
     * @param string|null $customMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomMetaTitle($customMetaTitle);

    /**
     * @return string|null
     */
    public function getCustomMetaKeywords();

    /**
     * @param string|null $customMetaKeywords
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomMetaKeywords($customMetaKeywords);

    /**
     * @return string|null
     */
    public function getCustomMetaDescription();

    /**
     * @param string|null $customMetaDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomMetaDescription($customMetaDescription);

    /**
     * @return string|null
     */
    public function getCustomCanonicalUrl();

    /**
     * @param string|null $customCanonicalUrl
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomCanonicalUrl($customCanonicalUrl);

    /**
     * @return int
     */
    public function getCustomRobots();

    /**
     * @param int $customRobots
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomRobots($customRobots);

    /**
     * @return string|null
     */
    public function getCustomH1Tag();

    /**
     * @param string|null $customH1Tag
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomH1Tag($customH1Tag);

    /**
     * @return string|null
     */
    public function getCustomInPageText();

    /**
     * @param string|null $customInPageText
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCustomInPageText($customInPageText);

    /**
     * @return string|null
     */
    public function getCatMetaTitle();

    /**
     * @param string|null $catMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatMetaTitle($catMetaTitle);

    /**
     * @return string|null
     */
    public function getCatMetaDescription();

    /**
     * @param string|null $catMetaDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatMetaDescription($catMetaDescription);

    /**
     * @return string|null
     */
    public function getCatMetaKeywords();

    /**
     * @param string|null $catMetaKeywords
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatMetaKeywords($catMetaKeywords);

    /**
     * @return string|null
     */
    public function getCatH1Tag();

    /**
     * @param string|null $catH1Tag
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatH1Tag($catH1Tag);

    /**
     * @return string|null
     */
    public function getCatDescription();

    /**
     * @param string|null $catDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatDescription($catDescription);

    /**
     * @return string|null
     */
    public function getCatImageAlt();

    /**
     * @param string|null $catImageAlt
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatImageAlt($catImageAlt);

    /**
     * @return string|null
     */
    public function getCatImageTitle();

    /**
     * @param string|null $catImageTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatImageTitle($catImageTitle);

    /**
     * @return string|null
     */
    public function getCatAfterProductText();

    /**
     * @param string|null $catAfterProductText
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setCatAfterProductText($catAfterProductText);

    /**
     * @return string|null
     */
    public function getProductMetaTitle();

    /**
     * @param string|null $productMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductMetaTitle($productMetaTitle);

    /**
     * @return string|null
     */
    public function getProductMetaKeywords();

    /**
     * @param string|null $productMetaKeywords
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductMetaKeywords($productMetaKeywords);

    /**
     * @return string|null
     */
    public function getProductMetaDescription();

    /**
     * @param string|null $productMetaDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductMetaDescription($productMetaDescription);

    /**
     * @return string|null
     */
    public function getProductH1Tag();

    /**
     * @param string|null $productH1Tag
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductH1Tag($productH1Tag);

    /**
     * @return string|null
     */
    public function getProductShortDescription();

    /**
     * @param string|null $productShortDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductShortDescription($productShortDescription);

    /**
     * @return string|null
     */
    public function getProductDescription();

    /**
     * @param string|null $productDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setProductDescription($productDescription);

    /**
     * @return string|null
     */
    public function getSubProductMetaTitle();

    /**
     * @param string|null $subProductMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductMetaTitle($subProductMetaTitle);

    /**
     * @return string|null
     */
    public function getSubProductMetaKeywords();

    /**
     * @param string|null $subProductMetaKeywords
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductMetaKeywords($subProductMetaKeywords);

    /**
     * @return string|null
     */
    public function getSubProductMetaDescription();

    /**
     * @param string|null $subProductMetaDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductMetaDescription($subProductMetaDescription);

    /**
     * @return string|null
     */
    public function getSubProductH1Tag();

    /**
     * @param string|null $subProductH1Tag
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductH1Tag($subProductH1Tag);

    /**
     * @return string|null
     */
    public function getSubProductShortDescription();

    /**
     * @param string|null $subProductShortDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductShortDescription($subProductShortDescription);

    /**
     * @return string|null
     */
    public function getSubProductDescription();

    /**
     * @param string|null $subProductDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setSubProductDescription($subProductDescription);

    /**
     * @return bool
     */
    public function getIsBrandConfig();

    /**
     * @param bool $brandMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setIsBrandConfig($isBrandConfig);

    /**
     * @return string|null
     */
    public function getBrandMetaTitle();

    /**
     * @param string|null $brandMetaTitle
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandMetaTitle($brandMetaTitle);

    /**
     * @return string|null
     */
    public function getBrandMetaDescription();

    /**
     * @param string|null $brandMetaDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandMetaDescription($brandMetaDescription);

    /**
     * @return string|null
     */
    public function getBrandMetaKeywords();

    /**
     * @param string|null $brandMetaKeywords
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandMetaKeywords($brandMetaKeywords);

    /**
     * @return string|null
     */
    public function getBrandH1Tag();

    /**
     * @param string|null $brandH1Tag
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandH1Tag($brandH1Tag);

    /**
     * @return string|null
     */
    public function getBrandDescription();

    /**
     * @param string|null $brandDescription
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandDescription($brandDescription);

    /**
     * @return string|null
     */
    public function getBrandAfterProductText();

    /**
     * @param string|null $brandAfterProductText
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function setBrandAfterProductText($brandAfterProductText);
}
