<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml;

class Messages extends \Magento\Backend\Block\Template
{
    public const ARMAH_BASE_SECTION_NAME = 'armah_base';
    /**
     * @var \Armah\Base\Model\AdminNotification\Messages
     */
    private $messageManager;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Armah\Base\Model\AdminNotification\Messages $messageManager,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageManager = $messageManager;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messageManager->getMessages();
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $html  = '';
        if ($this->request->getParam('section') === self::ARMAH_BASE_SECTION_NAME) {
            $html = parent::_toHtml();
        }

        return $html;
    }
}
