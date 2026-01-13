<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Cron;

use Armah\Base\Model\Feed\FeedTypes\Extensions;

class RefreshFeedData
{
    /**
     * @var Extensions
     */
    private $extensionsFeed;

    public function __construct(
        Extensions $extensionsFeed
    ) {
        $this->extensionsFeed = $extensionsFeed;
    }

    /**
     * Force reload feeds data
     */
    public function execute()
    {
        $this->extensionsFeed->getFeed();
    }
}
