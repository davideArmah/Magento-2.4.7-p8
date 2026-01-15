<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\InputType\FrontendCaster;

use Armah\Orderattr\Api\Data\CheckoutAttributeInterface;
use Armah\Orderattr\Model\Config\Source\DateFormat;
use Armah\Orderattr\Model\ConfigProvider;

class Date implements SpecificationProcessorInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * @param string[] $element
     * @param CheckoutAttributeInterface $attribute
     */
    public function processSpecificationByAttribute(array &$element, CheckoutAttributeInterface $attribute): void
    {
        $validationRules = $attribute->getValidationRules();
        $format = DateFormat::$formats[$this->configProvider->getDateFormat()]['format'];
        if (!isset($element['additionalClasses'])) {
            $element['additionalClasses'] = '';
        }
        $element['additionalClasses'] .= ' date';
        $element['options'] = [
            'dateFormat' => $this->configProvider->getDateFormatJs(),
            'showOn' => 'both'
        ];

        $element['inputDateFormat'] = $this->configProvider->getDateFormatJs();

        if (!empty($validationRules['date_range_min'])) {
            $element['options']['minDate'] = date($format, $validationRules['date_range_min']);
        }

        if (!empty($validationRules['date_range_max'])) {
            $element['options']['maxDate'] = date($format, $validationRules['date_range_max']);
        }

        if (!empty($element['value'])) {
            $element['value'] = date($format, strtotime($element['value']));
        }

        $element['validation']['amorder-attr-validate-date'] =
            ['dateFormat' => $this->configProvider->getDateFormatJs()];
    }
}
