<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Plugin\Framework\View\Page;

use Magento\Catalog\Model\Product\ProductList\Toolbar;
use Magento\Framework\View\Page\Config as NativeConfig;

class Config
{
    /**
     * @var string
     */
    protected $_pageVarName = 'p';

    /**
     * @var \Armah\SeoToolkitLite\Helper\Config
     */
    private $config;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * Config constructor.
     * @param \Armah\SeoToolkitLite\Helper\Config $config
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Armah\SeoToolkitLite\Helper\Config $config,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * @param NativeConfig $subject
     * @param $result
     * @return string
     */
    public function afterGetDescription(
        NativeConfig $subject,
        $result
    ) {
        if ($result && $this->config->isAddPageToMetaDescEnabled()) {
            $page = (int)$this->request->getParam($this->_pageVarName, false);
            if ($page) {
                $result .= __(' | Page %1', $page);
            }
        }

        return $result;
    }
}
