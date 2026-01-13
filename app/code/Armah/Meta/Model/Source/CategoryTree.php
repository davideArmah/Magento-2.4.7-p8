<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Model\Source;

class CategoryTree implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Armah\Meta\Helper\Data
     */
    private $dataHelper;

    public function __construct(\Armah\Meta\Helper\Data $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->dataHelper->getTree();
    }
}
