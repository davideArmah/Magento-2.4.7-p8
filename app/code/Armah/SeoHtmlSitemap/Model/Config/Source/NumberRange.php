<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package HTML Sitemap for Magento 2
 */

namespace Armah\SeoHtmlSitemap\Model\Config\Source;

class NumberRange implements \Magento\Framework\Option\ArrayInterface
{
    protected $_rangeMin = 1;

    protected $_rangeMax = 5;

    public function toOptionArray()
    {
        $data = [];
        for ($i = $this->_rangeMin; $i <= $this->_rangeMax; $i++) {
            $data[] = ['value' => $i, 'label' => $i];
        }

        return $data;
    }
}