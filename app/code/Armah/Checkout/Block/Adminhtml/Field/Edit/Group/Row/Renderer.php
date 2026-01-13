<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Block\Adminhtml\Field\Edit\Group\Row;

use Armah\Checkout\Api\Data\PlaceholderInterface;
use Armah\Checkout\Model\PlaceholderRepository;
use Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Group\Row\Renderer as CheckoutRender;
use Armah\CheckoutCore\Model\Field;
use Magento\Framework\App\ObjectManager;

class Renderer extends CheckoutRender
{
    /**
     * @var string
     */
    protected $_template = 'Armah_Checkout::widget/form/renderer/row.phtml';

    /**
     * @var string[]
     */
    private $allowedFrontendInputs = ['text', 'multiline', 'textarea'];

    /**
     * @param int $attributeId
     * @param int $storeId
     *
     * @return PlaceholderInterface|null
     */
    public function getPlaceholder(int $attributeId, int $storeId): ?PlaceholderInterface
    {
        $objectManager = ObjectManager::getInstance();
        $placeholderRepository = $objectManager->create(PlaceholderRepository::class);

        return $placeholderRepository->getByAttributeIdAndStoreId($attributeId, $storeId);
    }

    public function isPlaceholderForbidden(Field $field): bool
    {
        if ($field->getData('attribute_code') === 'region') {
            return true;
        }

        if (!in_array($field->getData('frontend_input'), $this->allowedFrontendInputs, true)) {
            return true;
        }

        return false;
    }
}
