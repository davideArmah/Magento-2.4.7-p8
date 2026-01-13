<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package HTML Sitemap for Magento 2
 */

namespace Armah\SeoHtmlSitemap\Model\ResourceModel\Page\Xlanding;

class CollectionFactory
{
    /**
     * Object manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create()
    {
        return $this->objectManager->create('Armah\Xlanding\Model\ResourceModel\Page\Collection');
    }

}