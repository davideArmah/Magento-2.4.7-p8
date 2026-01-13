<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Redirect\Command;

interface DeleteExpiredRedirectsInterface
{
    /**
     * @return void
     */
    public function execute(): void;
}
