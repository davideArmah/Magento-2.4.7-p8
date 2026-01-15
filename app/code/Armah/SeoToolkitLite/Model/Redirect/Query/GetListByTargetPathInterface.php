<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Redirect\Query;

use Armah\SeoToolkitLite\Model\ResourceModel\Redirect\Collection;

interface GetListByTargetPathInterface
{
    /**
     * @param string $targetPath
     * @return Collection
     */
    public function execute(string $targetPath): Collection;
}
