<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Controller;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;

class RouterPreRedirect extends RedirectRouterAbstract
{
    /**
     * @param RedirectInterface $redirect
     * @return bool
     */
    protected function isRedirectAllow(RedirectInterface $redirect): bool
    {
        return !$redirect->getUndefinedPageOnly();
    }
}
