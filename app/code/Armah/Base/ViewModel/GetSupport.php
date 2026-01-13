<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class GetSupport implements ArgumentInterface
{
    public function getSubmitTicketUrl(): string
    {
        return ''
            . '&layoutId=34453000000023011&utm_source=extension&utm_medium=backend&utm_campaign=submit_ticket';
    }

    public function getProSubscribeUrl(): string
    {
        return '';
    }

    public function getPremiumSubscribeUrl(): string
    {
        return '';
    }

    public function getArmahOneSubscribeUrl(): string
    {
        return '';
    }
}
