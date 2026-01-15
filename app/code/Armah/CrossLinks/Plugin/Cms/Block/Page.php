<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Plugin\Cms\Block;

use Magento\Cms\Block\Page as MagentoPageBlock;
use Armah\CrossLinks\Helper\Data as CrossLinksHelper;

class Page
{
    /**
     * @var \Armah\CrossLinks\Model\ReplaceManager
     */
    protected $replaceManager;

    /**
     * Page constructor.
     * @param \Armah\CrossLinks\Model\ReplaceManager $replaceManager
     */
    public function __construct(\Armah\CrossLinks\Model\ReplaceManager $replaceManager)
    {
        $this->replaceManager = $replaceManager;
    }

    /**
     * @param MagentoPageBlock $subject
     * @param $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterToHtml(MagentoPageBlock $subject, $result)
    {
        if ($subject->getPage() && $subject->getPage()->getIdentifier() !== 'armah-faq-home-page') {
            $this->replaceManager->setEntityType(CrossLinksHelper::TYPE_CMS);
            $result = $this->replaceManager->processCmsPageContent($result);
        }

        return $result;
    }
}
