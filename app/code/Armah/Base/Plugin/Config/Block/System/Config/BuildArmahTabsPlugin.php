<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\Config\Block\System\Config;

use Magento\Config\Block\System\Config\Tabs;
use Psr\Log\LoggerInterface;

class BuildArmahTabsPlugin
{
    public const ARMAH_TABS_CLASS = 'armah-tab arbase-tab-container';

    /**
     * @var \DOMDocumentFactory
     */
    private $domFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        \DOMDocumentFactory $domFactory,
        LoggerInterface $logger
    ) {
        $this->domFactory = $domFactory;
        $this->logger = $logger;
    }

    public function afterToHtml(Tabs $subject, string $result): string
    {
        $domDocument = $this->domFactory->create();

        try {
            $domDocument->loadXML($result);
            if ($node = $this->getArmahNode($domDocument)) {
                $tabsHtml = $subject->getLayout()->createBlock(
                    \Armah\Base\Block\Adminhtml\System\Config\Tabs::class,
                    'armah_config_tabs'
                )->toHtml();

                $fragment = $domDocument->createDocumentFragment();
                $fragment->appendXML($tabsHtml);
                $node->appendChild($fragment);
                $result = $domDocument->saveHTML();
            }
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }

        return $result;
    }

    private function getArmahNode(\DOMDocument $domDocument): ?\DOMElement
    {
        foreach ($domDocument->getElementsByTagName('div') as $node) {
            if (stripos($node->getAttribute('class'), self::ARMAH_TABS_CLASS) === false) {
                continue;
            }
            foreach ($node->getElementsByTagName('ul') as $ulNode) {
                $node->removeChild($ulNode);
            }

            return $node;
        }

        return null;
    }
}
