<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\System\Message;

use Magento\Framework\FlagManager;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\UrlInterface;

class LicenseInvalid implements MessageInterface
{
    public const IDENTITY_VALUE = 'ARMAH_GEOIP_LICENSE_INVALID';
    public const DISMISS_URL = 'armah_geoip/geoip/dismissnotification';

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var FlagManager
     */
    private $flagManager;

    public function __construct(
        UrlInterface $urlBuilder,
        FlagManager $flagManager
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->flagManager = $flagManager;
    }

    public function getIdentity(): string
    {
        return self::IDENTITY_VALUE;
    }

    public function isDisplayed(): bool
    {
        return (bool)$this->flagManager->getFlagData(self::IDENTITY_VALUE);
    }

    public function setIsDisplayed(bool $isDisplayed): void
    {
        $isDisplayed
            ? $this->flagManager->saveFlag(self::IDENTITY_VALUE, true)
            : $this->flagManager->deleteFlag(self::IDENTITY_VALUE);
    }

    public function getText(): string
    {
        return <<<MESSAGE
            <div class="amgeoip-license-message-container">
                <div class="amgeoip-license-message">
                    <b>Armah GeoIP Data:</b> Note that your IP database is not being refreshed via the Armah service
                    due to an inactive license status. To resolve this issue, please visit the
                    <a href="{$this->getConfigUrl()}">Configuration section</a>
                    and check the license status for the product that includes the Geo IP Data extension.
                </div>
                <div class="amgeoip-license-message-dismiss">
                    <a href="{$this->getDismissUrl()}">Dismiss</a>
                </div>
            </div>
        MESSAGE;
    }

    private function getDismissUrl(): string
    {
        return $this->urlBuilder->getUrl(self::DISMISS_URL);
    }

    private function getConfigUrl(): string
    {
        return $this->urlBuilder->getUrl('adminhtml/system_config/edit', ['section' => 'armah_products']);
    }

    public function getSeverity(): int
    {
        return self::SEVERITY_MAJOR;
    }

    public function toArray(): array
    {
        return [
            'text' => $this->getText(),
            'severity' => $this->getSeverity(),
            'identity' => $this->getIdentity()
        ];
    }
}
