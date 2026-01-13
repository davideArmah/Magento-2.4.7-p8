<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Controller\Adminhtml\Custom;

class Edit extends \Armah\Meta\Controller\Adminhtml\Config\Edit
{
    /**
     * @var string
     */
    protected $paramName = 'id';

    /**
     * @var string
     */
    protected $_blockName = 'Custom';
}
