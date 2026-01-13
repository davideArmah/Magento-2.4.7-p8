<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Config\Source;

class Boolean extends \Magento\Eav\Model\Entity\Attribute\Source\Boolean
{
    public const EMPTY_VALUE = -1;

    public function __construct(\Magento\Eav\Model\ResourceModel\Entity\AttributeFactory $eavAttrEntity)
    {
        $this->_options = [
            ['label' => ' ', 'value' => self::EMPTY_VALUE],
            ['label' => __('Yes'), 'value' => self::VALUE_YES],
            ['label' => __('No'), 'value' => self::VALUE_NO]
        ];
        parent::__construct($eavAttrEntity);
    }
}
