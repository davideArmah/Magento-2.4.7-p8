<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Source;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\Manager;

/**
 * @deprecated
 * @since 2.14.1
 * @see \Armah\Base\Block\Adminhtml\System\Config\Form\Field\Promo\PromoField
 */
class BestsellersMultiStore extends Field
{
    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(
        Context $context,
        Manager $moduleManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleManager = $moduleManager;
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        if (!$this->moduleManager->isEnabled('Armah_ImprovedSortingSubscriptionFunctionality')) {
            $element->setData('disabled', 'disabled');
            $element->setData(
                'comment',
                'The functionality is available as part of an active product subscription or support subscription.' .
                ' To upgrade and obtain functionality please follow the ' .
                '<a href="https://armah.it/amcustomer/account/products/' .
                '?utm_source=extension&utm_medium=backend&utm_campaign=upgrade_sorting">link</a>.'
            );
        }

        return parent::_getElementHtml($element);
    }
}
