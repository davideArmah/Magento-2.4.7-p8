<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Controller\Adminhtml\Link;

use Armah\CrossLinks\Api\LinkInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;

class InlineEdit extends \Armah\CrossLinks\Controller\Adminhtml\Link
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * InlineEdit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Armah\CrossLinks\Model\LinkFactory $linkFactory
     * @param \Armah\CrossLinks\Api\LinkRepositoryInterface $linkRepository
     * @param \Magento\Backend\Model\SessionFactory $sessionFactory
     * @param TypeListInterface $typeList
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Armah\CrossLinks\Model\LinkFactory $linkFactory,
        \Armah\CrossLinks\Api\LinkRepositoryInterface $linkRepository,
        \Magento\Backend\Model\SessionFactory $sessionFactory,
        TypeListInterface $typeList,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        JsonFactory $jsonFactory
    ) {
        parent::__construct(
            $context,
            $coreRegistry,
            $resultPageFactory,
            $linkFactory,
            $linkRepository,
            $sessionFactory,
            $typeList,
            $resultForwardFactory
        );
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $linkId) {
                    try {
                        $link = $this->linkRepository->get($linkId);
                    } catch (NoSuchEntityException $e) {
                        return $resultJson->setData([
                            'messages' => [__('The link does not longer exist')],
                            'error' => $error
                        ]);
                    }

                    try {
                        //phpcs:ignore
                        $link->setData(array_merge($link->getData(), $postItems[$linkId]));
                        $this->linkRepository->save($link);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithLinkId(
                            $link,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    private function getErrorWithLinkId(LinkInterface $link, Phrase $errorText): string
    {
        return '[Link ID: ' . $link->getId() . '] ' . $errorText;
    }
}
