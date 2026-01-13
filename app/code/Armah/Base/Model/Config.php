<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model;

use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class Config extends ConfigProviderAbstract
{
    /**
     * @var string
     */
    protected $pathPrefix = 'armah_base/';

    public const NOTIFICATIONS_FREQUENCY = 'notifications/frequency';
    public const NOTIFICATIONS_TYPE = 'notifications/type';

    public const ARMAH_MENU_ENABLE = 'menu/enable';

    public const UPDATE_FREQUENCY = 60 * 60 * 24;
    public const REMOVE_EXPIRED_FREQUENCY = 60 * 60 * 6; //4 times per day

    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * @var ReinitableConfigInterface
     */
    private $reinitableConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        ReinitableConfigInterface $reinitableConfig
    ) {
        parent::__construct($scopeConfig);
        $this->configWriter = $configWriter;
        $this->reinitableConfig = $reinitableConfig;
    }

    public function getEnabledNotificationTypes(): array
    {
        $value = $this->getValue(self::NOTIFICATIONS_TYPE);

        return empty($value)
            ? []
            : explode(',', $value);
    }

    public function isAdsEnabled(): bool
    {
        return false; //backward compatibility for some modules
    }

    public function isArmahMenuEnabled(): bool
    {
        return (bool)$this->getValue(self::ARMAH_MENU_ENABLE);
    }

    public function getCurrentFrequencyValue(): int
    {
        return $this->getValue(self::NOTIFICATIONS_FREQUENCY);
    }

    public function getFrequencyInSec(): int
    {
        return $this->getCurrentFrequencyValue() * self::UPDATE_FREQUENCY;
    }

    /**
     * Used for updating frequency from the Notification grid
     * @see \Armah\Base\Plugin\AdminNotification\Block\Grid\Renderer\Actions
     *
     * @param int $value
     *
     * @return void
     */
    public function changeFrequency(int $value): void
    {
        $this->configWriter->save($this->pathPrefix . self::NOTIFICATIONS_FREQUENCY, $value);
        $this->reinitableConfig->reinit();
        $this->clean();
    }
}
