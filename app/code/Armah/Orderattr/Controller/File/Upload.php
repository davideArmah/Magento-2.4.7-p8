<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */
namespace Armah\Orderattr\Controller\File;

use Armah\Orderattr\Model\Value\Metadata\Form\File\Uploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Upload implements HttpPostActionInterface
{
    public const PARAM_NAME = 'parar_name';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Uploader
     */
    private $fileUploader;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        RequestInterface $request,
        Uploader $fileUploader,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->fileUploader = $fileUploader;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if (!$this->request->isAjax()) {
            return;
        }

        $resultJson = $this->resultJsonFactory->create();
        $filename = $this->request->getParam(self::PARAM_NAME);

        if ($filename) {
            try {
                $result = $this->fileUploader->saveFile($filename);
            } catch (LocalizedException $e) {
                $result = ['error' => $e->getMessage()];
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $result = ['error' => __('Something went wrong.')];
            }
        } else {
            $result = ['error' => __('File is missing.')];
        }

        return $resultJson->setData($result);
    }
}
