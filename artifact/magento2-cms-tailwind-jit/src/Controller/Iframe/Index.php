<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyva Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Controller\Iframe;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutInterface;

/**
 * Controller to render the JIT iframe template on Storefront for cross-domain Admin/Storefront setups and CSP strict environments.
 * Using a Magento controller ensures correct Magento headers are applied.
 */
class Index implements HttpGetActionInterface
{
    /**
     * @var RawFactory
     */
    private $rawFactory;

    /**
     * @var LayoutInterface
     */
    private $layout;

    public function __construct(
        RawFactory $rawFactory,
        LayoutInterface $layout
    ) {
        $this->rawFactory = $rawFactory;
        $this->layout = $layout;
    }

    public function execute()
    {
        $resultRaw = $this->rawFactory->create();

        /** @var \Magento\Framework\View\Element\Template $block */
        $block = $this->layout->createBlock(\Magento\Framework\View\Element\Template::class);
        $block->setTemplate('Hyva_CmsTailwindJit::tailwindcss-jit-iframe-content-storefront.phtml');

        $resultRaw->setContents($block->toHtml());
        return $resultRaw;
    }
}
