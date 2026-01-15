<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs;

use Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs\AbstractTab;

class AdditionalOptions extends AbstractTab
{
    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return __('Additional Options');
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('armah_');

        $fieldset = $form->addFieldset('additional_fieldset', ['legend' => __('Additional Options')]);

        $fieldset->addField(
            'additional_field',
            'text',
            [
                'label' => __('Additional Options'),
                'title' => __('Additional Options'),
                'name' => 'additional_field',
            ]
        );

        $layout = $this->getLayout();

        $form->getElement(
            'additional_field'
        )->setRenderer(
            $layout->createBlock(\Armah\CheckoutCore\Block\Adminhtml\Field\Edit\AdditionalOptions::class)
            ->setTemplate('Armah_CheckoutCore::fields/edit/additional_options.phtml')
        );

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
