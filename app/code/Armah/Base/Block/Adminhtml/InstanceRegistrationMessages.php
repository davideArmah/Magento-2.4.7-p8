<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class InstanceRegistrationMessages extends Field
{
    public const SECTION_NAME = 'armah_products';

    /**
     * @var string
     */
    protected $_template = 'Armah_Base::config/instance_registration.phtml';

    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function isArmahProductsSection(): bool
    {
        return $this->getRequest()->getParam('section') === self::SECTION_NAME;
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->toHtml();
    }
}
