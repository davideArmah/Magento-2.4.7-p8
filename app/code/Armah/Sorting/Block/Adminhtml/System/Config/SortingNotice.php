<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

class SortingNotice extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * @var \Armah\Sorting\Model\Di\Wrapper
     */
    private $ruleCollection;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Armah\Sorting\Model\Di\Wrapper $ruleCollection,
        array $data = []
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data);
        $this->ruleCollection = $ruleCollection;
    }

    public function render(AbstractElement $element)
    {
        $this->setElement($element);
        $header = $this->_getHeaderHtml($element);

        $elements = $this->_getChildrenElementsHtml($element);

        $footer = $this->_getFooterHtml($element);

        $notice = $this->generateNoticeMessageHtml();

        return   $header . $notice . $elements . $footer;
    }

    /**
     * @return string
     */
    private function generateNoticeMessageHtml(): string
    {
        $content = '';

        if ($this->ruleCollection->getSize()) {
            $content = '<div class="armah-info-block">'
                . '<div class="armah-additional-content"><span class="message message-notice">'
                . __(
                    'Please kindly note: if products on a search results page match the conditions of  Armah Elastic '
                    . 'Search Relevance Rules, the settings listed below will be ignored and products '
                    . 'will get sorted by relevance'
                )
                . '</div></div></div>';
        }

        return $content;
    }
}
