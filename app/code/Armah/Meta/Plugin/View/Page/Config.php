<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Plugin\View\Page;

use \Armah\Meta\Helper\Data;

class Config
{
    /**
     * @var \Armah\Meta\Helper\Data
     */
    private $data;

    public function __construct(
        Data $dataHelper
    ) {
        $this->data = $dataHelper;
    }

    /**
     * @param $pageConfig
     * @param $metaTitle
     * @return array
     */
    public function beforeSetMetaTitle(
        $pageConfig,
        $metaTitle
    ) {
        $replacedMetaTitle = $this->data->getReplaceData('meta_title');

        if ($replacedMetaTitle) {
            $metaTitle = $replacedMetaTitle;
        }

        return [$metaTitle];
    }

    /**
     * @param $pageConfig
     * @param $metaKeywords
     * @return bool|mixed|string
     */
    public function afterGetKeywords(
        $pageConfig,
        $metaKeywords
    ) {
        $replacedMetaKeywords = $this->data->getReplaceData('meta_keywords');

        if ($replacedMetaKeywords) {
            $metaKeywords = $replacedMetaKeywords;
        }

        return $metaKeywords;
    }

    /**
     * @param $pageConfig
     * @param $metaDescription
     * @return bool|mixed|string
     */
    public function afterGetDescription(
        $pageConfig,
        $metaDescription
    ) {
        $replacedMetaDesc = $this->data->getReplaceData('meta_description');

        if ($replacedMetaDesc) {
            $metaDescription = $replacedMetaDesc;
        }

        return $metaDescription;
    }

    /**
     * @param $pageConfig
     * @param $metaRobots
     * @return bool|mixed|string
     */
    public function afterGetRobots(
        $pageConfig,
        $metaRobots
    ) {
        $replacedMetaRobots = $this->data->getReplaceData('meta_robots');

        if ($replacedMetaRobots) {
            $metaRobots = $replacedMetaRobots;
        }

        return $metaRobots;
    }
}
