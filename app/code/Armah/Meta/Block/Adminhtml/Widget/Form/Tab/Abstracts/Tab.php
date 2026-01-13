<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Block\Adminhtml\Widget\Form\Tab\Abstracts;
use Magento\Framework\Data\FormFactory;

abstract class Tab extends \Magento\Backend\Block\Widget\Form
{
    protected $_prefix = '';
    protected $_title = '';
    protected $_fieldsetId = '';

    /**
     * @var \Armah\Meta\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var \Armah\Meta\Model\System\Store
     */
    protected $store;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $_formFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Armah\Meta\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        FormFactory $formFactory,
        \Armah\Meta\Model\System\Store $store,
        array $data = []
    ) {
        $this->dataHelper = $dataHelper;
        $this->store = $store;
        $this->_coreRegistry = $registry;
        $this->_formFactory = $formFactory;
        parent::__construct($context, $data);
    }

    protected abstract function _addFieldsToFieldset($fieldset);

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $this->setForm($form);

        $model = $this->_coreRegistry->registry('armeta_config');

        $fieldSet = $form->addFieldset(
            $this->_fieldsetId,
            array('legend' => $this->_title)
        );

        $this->_addFieldsToFieldset($fieldSet);

        //set form values
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}