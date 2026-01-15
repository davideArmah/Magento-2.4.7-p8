<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Plugin;

use Armah\CrossLinks\Helper\Data as CrossLinksHelper;

class Faq
{
    /**
     * @var \Armah\CrossLinks\Model\ReplaceManager
     */
    private $replaceManager;

    /**
     * @var CrossLinksHelper
     */
    private $helper;

    public function __construct(
        CrossLinksHelper $helper,
        \Armah\CrossLinks\Model\ReplaceManager $replaceManager
    ) {
        $this->replaceManager = $replaceManager;
        $this->helper = $helper;
    }

    /**
     * @param $subject
     * @param $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterWrapContent($subject, $result)
    {
        if ($result && $this->helper->isActiveForFaq()) {
            $result = $this->replaceManager->processFaqPageContent($result);
        }

        return $result;
    }
}
