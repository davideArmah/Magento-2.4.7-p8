<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package HTML Sitemap for Magento 2
 */

namespace Armah\SeoHtmlSitemap\Block\Adminhtml\Form\Field;

use Armah\SeoHtmlSitemap\Helper\Data as SitemapHelper;
use Armah\SeoHtmlSitemap\Model\ConfigProvider;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\Manager;

class Position extends Field
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(
        SitemapHelper $helper,
        Context $context,
        Manager $manager,
        ?ConfigProvider $configProvider = null //TODO: move to not optional
    ) {
        parent::__construct($context);
        $this->manager = $manager;
        $this->configProvider = $configProvider ?? ObjectManager::getInstance()->get(ConfigProvider::class);
    }

    protected function _construct()
    {
        $this->setTemplate('Armah_SeoHtmlSitemap::form/field/position.phtml');
    }

    public function render(AbstractElement $element): string
    {
        $this->setElement($element);

        return $this->_toHtml();
    }

    public function getPositions(): ?array
    {
        $scopeId = (int)$this->getElement()->getScopeId();
        $positions = $this->configProvider->getSortOrder($scopeId);

        if ($this->manager->isEnabled('Armah_Xlanding')) {
            $positions['landing_pages'] = 'Landing pages';
        } else {
            unset($positions['landing_pages']);
        }

        return $positions;
    }

    /**
     * @param $index
     * @return string
     */
    public function getNamePrefix($index)
    {
        return $this->getElement()->getName() . '[' . $index . ']';
    }
}
