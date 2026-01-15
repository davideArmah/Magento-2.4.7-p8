<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\InputType;

use Armah\Orderattr\Model\Attribute\InputType\InputTypeProvider;

class GridUiCaster
{
    /**
     * @var InputTypeProvider
     */
    private $inputTypeProvider;

    /**
     * @var int
     */
    protected $columnSortOrder = 100;

    /**
     * @var \Armah\Orderattr\Model\ConfigProvider
     */
    private $configProvider;

    /**
     * GridUiCaster constructor.
     *
     * @param \Armah\Orderattr\Model\Attribute\InputType\InputTypeProvider $inputTypeProvider
     */
    public function __construct(
        InputTypeProvider $inputTypeProvider,
        \Armah\Orderattr\Model\ConfigProvider $configProvider
    ) {
        $this->inputTypeProvider = $inputTypeProvider;
        $this->configProvider = $configProvider;
    }

    /**
     * @param \Armah\Orderattr\Model\Attribute\Attribute $attribute
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     *
     * @return array
     */
    public function execute($attribute, $context)
    {
        /** @var \Armah\Orderattr\Model\Attribute\InputType\InputType $inputType */
        $inputType = $this->inputTypeProvider->getAttributeInputType($attribute->getFrontendInput());

        $config = [
            'sortOrder' => $this->columnSortOrder++,
            'add_field' => false,
            'label' => $attribute->getDefaultFrontendLabel(),
            'dataType' => $inputType->getColumnDatatype(),
            'visible' => true,
            'filter' =>  null,
            'component' => $inputType->getColumnUiComponent()
        ];

        if ($inputType->isFilterableInGrid()) {
            $config['filter'] = $inputType->getColumnUiFilter();
//            $config['editor'] = $inputType->getColumnUiFilter();
        }

        if ($inputType->getSourceModel()) {
            $config['options'] = $attribute->getSource()->getAllOptions(true, true);
        }
        switch ($inputType->getFrontendInputType()) {
            case 'date':
                $config['dateFormat'] = $this->configProvider->getDateFormatJs();
                break;
            case 'datetime':
                $config['dateFormat'] = $this->configProvider->getDateFormatJs()
                    . ' ' . $this->configProvider->getTimeFormatJs();
                break;
        }

        $arguments = [
            'data' => [
                'config' => $config,
            ],
            'context' => $context,
        ];

        return $arguments;
    }
}
