<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Block\Adminhtml\Field\Edit\Group;

use Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Group\Renderer as CheckoutRender;

class Renderer extends CheckoutRender
{
    /**
     * @var string
     */
    protected $_template = 'Armah_Checkout::widget/form/renderer/group.phtml';
}
