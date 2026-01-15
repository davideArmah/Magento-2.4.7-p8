<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Plugin\View\Asset;

class Repository
{
    /**
     * @var \Armah\Meta\Helper\Data
     */
    private $data;

    public function __construct(
        \Armah\Meta\Helper\Data $data
    ) {
        $this->data = $data;
    }

    public function aroundCreateRemoteAsset(
        $subject,
        \Closure $proceed,
        $url,
        $contentType
    ) {
        $result = $proceed($url, $contentType);

        $canonical = $this->data->getReplaceData('custom_canonical_url');

        if ($contentType=='canonical' && $canonical) {
            $result = $proceed($canonical, $contentType);
        }

        return $result;
    }
}
