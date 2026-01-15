<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Plugin\Cms\Model;

class Page
{

    /**
     * @var \Armah\Meta\Helper\Data
     */
    protected $data;

    public function __construct(
        \Armah\Meta\Helper\Data $dataHelper
    ) {
        $this->data = $dataHelper;
    }

    public function afterGetMetaKeywords(
        $metaKeywords
    ) {
        $replacedMetaKeywords = $this->data->getReplaceData('meta_keywords');
        if ($replacedMetaKeywords) {
            return $replacedMetaKeywords;
        }
        return $metaKeywords;
    }
}