<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Controller\Adminhtml\Config;

use Armah\Meta\Api\Data\ConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends \Armah\Meta\Controller\Adminhtml\Config
{
    /**
     * @var string
     */
    protected $paramName = 'config_id';

    public function execute()
    {
        $data  = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $id = $this->getRequest()->getParam($this->paramName);
                if ($id) {
                    $model = $this->configRepository->getById($id);
                } else {
                    $model = $this->configFactory->create();
                }

                $model->addData($data);
                $this->configRepository->save($model);

                $msg = __('%1 has been successfully saved', $this->_title);
                $this->messageManager->addSuccessMessage($msg);
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', [$this->paramName => $model->getId()]);
                } else {
                    return $this->_redirect('*/*');
                }
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This Template no longer exists.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->critical($e);
                return $this->_redirect('*/*/edit', [$this->paramName => $id]);
            }

            return $this->_redirect('*/*');
        }

        $this->messageManager->addErrorMessage(__('Unable to find a record to save'));
        return $this->_redirect('*/*');
    }
}
