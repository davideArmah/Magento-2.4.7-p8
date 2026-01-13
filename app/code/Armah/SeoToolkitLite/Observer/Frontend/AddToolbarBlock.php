<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Observer\Frontend;

use Armah\SeoToolkitLite\Block\Toolbar;
use Armah\SeoToolkitLite\Model\Toolbar\IsToolbarEnabled;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\BlockFactory;

/**
 * controller_front_send_response_before
 */
class AddToolbarBlock implements ObserverInterface
{
    /**
     * @var IsToolbarEnabled
     */
    private $isToolbarEnabled;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    public function __construct(
        IsToolbarEnabled $isToolbarEnabled,
        BlockFactory $blockFactory
    ) {
        $this->isToolbarEnabled = $isToolbarEnabled;
        $this->blockFactory = $blockFactory;
    }

    public function execute(Observer $observer)
    {
        if (!$this->isToolbarEnabled->execute() || !$this->canProceed($observer->getEvent())) {
            return;
        }

        $response = $observer->getEvent()->getResponse();
        $body = $response->getBody();
        $block = $this->blockFactory->createBlock(
            Toolbar::class,
            ['data' => ['html' => $body]]
        );

        $html = $block->toHtml();
        if ($html) {
            $body = str_replace('</body>', $html . '</body>', $body);
            $response->setBody($body);
        }
    }

    private function canProceed(Event $event): bool
    {
        /** @var HttpRequest $request */
        $request = $event->getRequest();
        if ($request->isAjax() || !$request->isGet()) {
            return false;
        }

        /** @var ResponseInterface $response */
        $response = $event->getResponse();
        if (!$response instanceof HttpResponse) {
            return false;
        }

        return true;
    }
}
