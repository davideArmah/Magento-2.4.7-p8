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
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\Bundle\DataBundle;
use Magento\Framework\Locale\ResolverInterface;

class Datetime implements SpecificationProcessorInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var string
     */
    protected $locale;

    public function __construct(
        ConfigProvider $configProvider,
        ?ResolverInterface $localeResolver = null
    ) {
        $this->configProvider = $configProvider;
        $this->locale = $localeResolver
            ? $localeResolver->getLocale()
            : ObjectManager::getInstance()->get(ResolverInterface::class)->getLocale();
    }

    /**
     * @param string[] $element
     * @param CheckoutAttributeInterface $attribute
     */
    public function processSpecificationByAttribute(array &$element, CheckoutAttributeInterface $attribute): void
    {
        $validationRules = $attribute->getValidationRules();
        $format = DateFormat::$formats[$this->configProvider->getDateFormat()]['format'];
        $localeData = (new DataBundle())->get($this->locale);

        if (!isset($element['additionalClasses'])) {
            $element['additionalClasses'] = '';
        }
        $element['additionalClasses'] .= ' date';
        $element['dataType'] = $element['formElement'] = 'date';
        $element['options'] = [
            'dateFormat' => $this->configProvider->getDateFormatJs(),
            'showsTime'  => true,
            'timeFormat' =>  $this->configProvider->getTimeFormatJs(),
            'showOn' => 'both',
            'storeLocale' => $this->locale,
            'amNames' => [$localeData['calendar']['gregorian']['AmPmMarkers'][0]],
            'pmNames' => [$localeData['calendar']['gregorian']['AmPmMarkers'][1]],
        ];

        if (!empty($element['value'])) {
            $element['value'] = date(
                $format . ' ' . $this->configProvider->getTimeFormat(),
                strtotime($element['value'])
            );
        }

        if (!empty($validationRules['date_range_min'])) {
            $element['options']['minDate'] = date($format, $validationRules['date_range_min']);
        }

        if (!empty($validationRules['date_range_max'])) {
            $element['options']['maxDate'] = date($format, $validationRules['date_range_max']);
        }
    }
}
