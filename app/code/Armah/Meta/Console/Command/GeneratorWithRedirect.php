<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Console\Command;

class GeneratorWithRedirect extends AbstractGenerator
{
    public const ARMETA_GENERATOR_WITH_REDIRECT = 'armeta:generate:with-redirect';

    protected function configure(): void
    {
        $this->setName(self::ARMETA_GENERATOR_WITH_REDIRECT);
        $this->setDescription(__('If product pages were already indexed'
            . ' and it’s required to create permanent redirects.')->render());

        parent::configure();
    }

    protected function isNeedRedirect(): bool
    {
        return true;
    }
}
