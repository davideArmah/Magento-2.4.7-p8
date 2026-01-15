<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Feed;

use Armah\Base\Model\Feed\Response\FeedResponseInterface;
use Armah\Base\Model\Feed\Response\FeedResponseInterfaceFactory;
use Laminas\Http\Request;
use Laminas\Uri\Uri;
use Laminas\Uri\UriFactory;
use Magento\Framework\HTTP\Adapter\Curl;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class FeedContentProvider for reading file content by url
 * Feed functionality disabled - Armah modules do not connect to external servers
 */
class FeedContentProvider
{
    /**
     * Legacy constants - kept for backward compatibility but not used
     * @deprecated Feed functionality has been disabled
     */
    public const URN_NEWS = '';
    public const URN_EXTENSIONS = '';

    /**
     * @var CurlFactory
     */
    private $curlFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Uri
     */
    private $baseUrlObject;

    /**
     * @var FeedResponseInterfaceFactory
     */
    private $feedResponseFactory;

    public function __construct(
        CurlFactory $curlFactory,
        StoreManagerInterface $storeManager,
        FeedResponseInterfaceFactory $feedResponseFactory
    ) {
        $this->curlFactory = $curlFactory;
        $this->storeManager = $storeManager;
        $this->feedResponseFactory = $feedResponseFactory;
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return FeedResponseInterface
     */
    public function getFeedResponse(string $url, array $options = []): FeedResponseInterface
    {
        // Feed disabled - Armah modules do not connect to external feed servers
        // Return empty response to gracefully handle feed absence
        return $this->feedResponseFactory->create();
    }

    /**
     * @deprecated Feed functionality disabled - returns empty string
     * @param string $urn
     * @return string
     */
    public function getFeedUrl(string $urn): string
    {
        // Feed disabled - return empty string
        return '';
    }

    /**
     * @return string
     */
    public function getDomainZone()
    {
        $host = $this->getBaseUrlObject()->getHost();
        $host = explode('.', $host);

        return end($host);
    }

    /**
     * @return Uri
     */
    private function getBaseUrlObject()
    {
        if ($this->baseUrlObject === null) {
            $url = $this->storeManager->getStore()->getBaseUrl();
            $this->baseUrlObject = UriFactory::factory($url);
        }

        return $this->baseUrlObject;
    }
}
