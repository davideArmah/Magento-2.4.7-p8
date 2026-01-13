<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Plugin\Blog\Model;

use Armah\Blog\Model\Posts;
use Armah\CrossLinks\Helper\Data as CrossLinksHelper;
use Armah\CrossLinks\Model\ReplaceManager;

class PostsPlugin
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
        ReplaceManager $replaceManager
    ) {
        $this->replaceManager = $replaceManager;
        $this->helper = $helper;
    }

    /**
     * @param Posts $subject
     * @param string $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetFullContent(Posts $subject, string $result)
    {
        return $this->processContent($result);
    }

    /**
     * @param Posts $subject
     * @param string $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetShortContent(Posts $subject, string $result)
    {
        return  $this->processContent($result);
    }

    /**
     * @param string $content
     * @return string
     */
    private function processContent(string $content)
    {
        if ($content && $this->helper->isActiveForBlog()) {
            $content = $this->replaceManager->processBlogPageContent($content);
        }

        return $content;
    }
}
