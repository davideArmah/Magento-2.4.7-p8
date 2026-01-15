<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Plugin\Catalog\Block\Category;

class View
{

    /**
     * @var \Armah\Meta\Helper\Data
     */
    private $data;

    public function __construct(
        \Armah\Meta\Helper\Data $data
    ) {
        $this->data = $data;
    }

    public function afterGetProductListHtml(
        $subject,
        $html
    ) {
        $textAfter = $this->data->getReplaceData('after_product_text');
        if ($textAfter) {
            $html =  $html . $textAfter;
        }

        return $html;
    }
}
