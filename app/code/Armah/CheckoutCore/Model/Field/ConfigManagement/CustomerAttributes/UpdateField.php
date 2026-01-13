<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\CustomerAttributes;

use Armah\CheckoutCore\Cache\InvalidateCheckoutCache;
use Armah\CheckoutCore\Model\Field\ConfigManagement\UpdateDefaultField;
use Armah\CheckoutCore\Model\Field\ConfigManagement\UpdateFieldsByWebsiteId;
use Armah\CheckoutCore\Plugin\Customer\Model\Attribute\SetWebsitePlugin;
use Magento\Customer\Model\Attribute;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\Website;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdateField
{
    public const FLAG_NO_FIELD_UPDATE = 'no_checkout_field_update';

    /**
     * @var UpdateDefaultField
     */
    private $updateDefaultField;

    /**
     * @var UpdateFieldsByWebsiteId
     */
    private $updateFieldsByWebsiteId;

    /**
     * @var InvalidateCheckoutCache
     */
    private $invalidateCheckoutCache;

    public function __construct(
        UpdateDefaultField $updateDefaultField,
        UpdateFieldsByWebsiteId $updateFieldsByWebsiteId,
        InvalidateCheckoutCache $invalidateCheckoutCache
    ) {
        $this->updateDefaultField = $updateDefaultField;
        $this->updateFieldsByWebsiteId = $updateFieldsByWebsiteId;
        $this->invalidateCheckoutCache = $invalidateCheckoutCache;
    }

    /**
     * @param Attribute $attribute
     * @return void
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function execute(Attribute $attribute): void
    {
        if ($attribute->hasData(self::FLAG_NO_FIELD_UPDATE)) {
            return;
        }

        $attributeId = (int) $attribute->getAttributeId();

        /** @var Website|null $website */
        $website = $attribute->getData(SetWebsitePlugin::KEY_WEBSITE);
        if ($website) {
            $isEnabled = (bool) $attribute->getIsVisible();
            $isRequired = $isEnabled && $attribute->getIsRequired();

            $this->updateFieldsByWebsiteId->execute(
                $attributeId,
                (int) $website->getId(),
                $isEnabled,
                $isRequired
            );

            $this->invalidateCheckoutCache->execute();

            return;
        }

        $isEnabled = (bool) $attribute->getData('is_visible');
        $isRequired = $isEnabled && $attribute->getData('is_required');
        $this->updateDefaultField->execute($attributeId, $isEnabled, $isRequired);
        $this->invalidateCheckoutCache->execute();
    }
}
