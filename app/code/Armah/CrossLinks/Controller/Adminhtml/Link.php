<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Controller\Adminhtml;

use Armah\CrossLinks\Api\LinkRepositoryInterface;
use Magento\Framework\App\Cache\TypeListInterface;

abstract class Link extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Armah_CrossLinks::seo';

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Armah\CrossLinks\Model\LinkFactory
     */
    protected $linkFactory;

    /**
     * @var \Magento\Backend\Model\SessionFactory
     */
    protected $sessionFactory;

    /**
     * @var  TypeListInterface
     */
    protected $cacheTypeList;

    /**
     * @var LinkRepositoryInterface
     */
    protected $linkRepository;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * Group constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Armah\CrossLinks\Model\LinkFactory $linkFactory
     * @param \Magento\Backend\Model\SessionFactory $sessionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Armah\CrossLinks\Model\LinkFactory $linkFactory,
        \Armah\CrossLinks\Api\LinkRepositoryInterface $linkRepository,
        \Magento\Backend\Model\SessionFactory $sessionFactory,
        TypeListInterface $typeList,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->linkFactory = $linkFactory;
        $this->linkRepository = $linkRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->sessionFactory = $sessionFactory;
        $this->cacheTypeList = $typeList;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
}
