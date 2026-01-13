<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Cron\Redirects;

use Armah\SeoToolkitLite\Model\Redirect\Command\DeleteExpiredRedirectsInterface;

class DeleteExpired
{
    /**
     * @var DeleteExpiredRedirectsInterface
     */
    private $deleteExpiredRedirects;

    public function __construct(
        DeleteExpiredRedirectsInterface $deleteExpiredRedirects
    ) {
        $this->deleteExpiredRedirects = $deleteExpiredRedirects;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $this->deleteExpiredRedirects->execute();
    }
}
