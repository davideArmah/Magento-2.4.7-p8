<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Console\Command;

class GeneratorWithoutRedirect extends AbstractGenerator
{
    public const ARMETA_GENERATOR_WITHOUT_REDIRECT = 'armeta:generate:without-redirect';

    protected function configure(): void
    {
        $this->setName(self::ARMETA_GENERATOR_WITHOUT_REDIRECT);
        $this->setDescription(__('If you don’t need to create redirects.')->render());

        parent::configure();
    }

    protected function isNeedRedirect(): bool
    {
        return false;
    }
}
