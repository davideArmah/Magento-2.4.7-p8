<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs;

use Magento\Store\Model\ScopeInterface;
use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Api\Data\ManageCheckoutTabsInterface;
use Armah\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs\AbstractTab;

class PaymentMethod extends AbstractTab
{
    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return __('Payment Method');
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $storeId = $this->_request->getParam(ScopeInterface::SCOPE_STORE, Field::DEFAULT_STORE_ID);
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->formManagement->prepareForm(ManageCheckoutTabsInterface::PAYMENT_METHOD_TAB, $storeId);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
