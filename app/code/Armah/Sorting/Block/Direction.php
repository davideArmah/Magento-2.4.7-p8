<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Block;

use Armah\Sorting\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Armah\Base\Model\Serializer as JsonSerializer;

class Direction extends Template
{
    public const PERMANENT_DIRECTION_ATTRIBUTES = [
        'price_asc',
        'price_desc'
    ];

    /**
     * @var string
     */
    protected $_template = 'Armah_Sorting::direction.phtml';

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var JsonSerializer
     */
    private $jsonSerializer;

    public function __construct(
        Data $helper,
        JsonSerializer $jsonSerializer,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $result = '';

        if ($this->isDirectionCanBeHide()) {
            $result = parent::_toHtml();
        }

        return $result;
    }

    /**
     * @return bool
     */
    private function isDirectionCanBeHide(): bool
    {
        $result = false;
        foreach ($this->getPermanentDirectionAttributes() as $attribute) {
            if ($result = !$this->helper->isMethodDisabled($attribute)) {
                break;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getPermanentDirectionAttributes(): array
    {
        return static::PERMANENT_DIRECTION_ATTRIBUTES;
    }

    /**
     * @return string
     */
    public function getPermanentDirectionAttributesJson(): string
    {
        return $this->jsonSerializer->serialize($this->getPermanentDirectionAttributes());
    }
}
