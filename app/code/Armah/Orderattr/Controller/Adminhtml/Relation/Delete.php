<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Relation;

use Magento\Backend\App\Action;
use Armah\Orderattr\Api\RelationRepositoryInterface;

class Delete extends \Armah\Orderattr\Controller\Adminhtml\Relation
{
    /**
     * @var RelationRepositoryInterface
     */
    private $repository;

    public function __construct(
        Action\Context $context,
        RelationRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    public function execute()
    {
        if ($relationId = $this->getRequest()->getParam('relation_id')) {
            try {
                $this->repository->deleteById($relationId);
                $this->messageManager->addSuccessMessage(__('The Relation has been deleted.'));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This Relation does not exist.'));
            }
        }

        return $this->_redirect('*/*/');
    }
}
