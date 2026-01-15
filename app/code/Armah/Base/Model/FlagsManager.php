<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model;

use Magento\Framework\FlagManager;

class FlagsManager
{
    public const FIRST_MODULE_RUN = 'armah_base_first_module_run';
    public const LAST_UPDATE = 'armah_base_last_update';
    public const REMOVE_DATE = 'armah_base_remove_date';

    /**
     * @var FlagManager
     */
    private $flagManager;

    public function __construct(
        FlagManager $flagManager
    ) {
        $this->flagManager = $flagManager;
    }

    public function getFirstModuleRun(): int
    {
        if (!($result = $this->getFlag(self::FIRST_MODULE_RUN))) {
            $result = time();
            $this->setFirstModuleRun($result);
        }

        return (int)$result;
    }

    public function setFirstModuleRun(?int $value = null): void
    {
        $value = $value ?? time();
        $this->saveFlag(self::FIRST_MODULE_RUN, (string)$value);
    }

    public function getLastUpdate(): int
    {
        return (int)$this->getFlag(self::LAST_UPDATE);
    }

    public function setLastUpdate(?int $value = null): void
    {
        $value = $value ?? time();
        $this->saveFlag(self::LAST_UPDATE, (string)$value);
    }

    public function getLastRemoval(): int
    {
        return (int)$this->getFlag(self::REMOVE_DATE);
    }

    public function setLastRemoval(?int $value = null): void
    {
        $value = $value ?? time();
        $this->saveFlag(self::REMOVE_DATE, (string)$value);
    }

    private function getFlag(string $code): string
    {
        return (string)$this->flagManager->getFlagData($code);
    }

    private function saveFlag(string $code, string $value): void
    {
        $this->flagManager->saveFlag($code, $value);
    }
}
