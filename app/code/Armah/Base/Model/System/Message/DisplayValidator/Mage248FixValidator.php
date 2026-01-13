<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\System\Message\DisplayValidator;

use Armah\Base\Model\MagentoVersion;
use Magento\Framework\Module\Manager;

class Mage248FixValidator implements DisplayValidatorInterface
{
    private const MAGENTO_VERSIONS = ['2.4.8', '2.4.8-p1'];
    private const FIX_MODULE = 'Armah_Mage248Fix';

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var MagentoVersion
     */
    private $magentoVersion;

    public function __construct(
        Manager $moduleManager,
        MagentoVersion $magentoVersion
    ) {
        $this->moduleManager = $moduleManager;
        $this->magentoVersion = $magentoVersion;
    }

    public function needToShow(): bool
    {
        return in_array($this->magentoVersion->get(), self::MAGENTO_VERSIONS)
            && !$this->moduleManager->isEnabled(self::FIX_MODULE);
    }
}
