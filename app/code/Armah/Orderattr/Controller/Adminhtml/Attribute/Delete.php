<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Attribute;

use Armah\Orderattr\Api\CheckoutAttributeRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Armah\Orderattr\Controller\Adminhtml\Attribute;

class Delete extends Attribute
{
    /**
     * @var CheckoutAttributeRepositoryInterface
     */
    private $attributeRepository;

    public function __construct(
        Context $context,
        CheckoutAttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct($context);
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        if ($id) {
            try {
                $attribute = $this->attributeRepository->getById($id);
                $this->attributeRepository->delete($attribute);
                $this->messageManager->addSuccessMessage(__('You deleted the order attribute.'));

                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $this->_redirect(
                    '*/*/edit',
                    ['attribute_id' => $this->getRequest()->getParam('attribute_id')]
                );
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find an attribute to delete.'));

        return $this->_redirect('*/*/');
    }
}
