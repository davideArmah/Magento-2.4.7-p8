<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model;

use Armah\CrossLinks\Api\LinkRepositoryInterface;
use Armah\CrossLinks\Api\LinkInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class LinkRepository
 * @package Armah\CrossLinks\Model
 */
class LinkRepository implements LinkRepositoryInterface
{
    /**
     * @var \Armah\CrossLinks\Model\ResourceModel\Link
     */
    protected $_resource;

    /**
     * @var LinkFactory
     */
    protected $_factory;

    /**
     * AbstractGiftCardEntityRepository constructor.
     * @param ResourceModel\Link $resource
     * @param LinkFactory $factory
     */
    public function __construct(
        \Armah\CrossLinks\Model\ResourceModel\Link $resource,
        \Armah\CrossLinks\Model\LinkFactory $factory
    ) {
        $this->_resource = $resource;
        $this->_factory = $factory;
    }

    /**
     * @param int $id
     * @return LinkInterface
     * @throws NoSuchEntityException
     */
    public function get($id)
    {
        $entity = $this->_factory->create();
        $this->_resource->load($entity, $id);
        if (!$entity->getId()) {
            throw new NoSuchEntityException(__('Requested link doesn\'t exist'));
        }
        return $entity;
    }

    /**
     * @param LinkInterface $entity
     * @return $this
     */
    public function save(LinkInterface $entity)
    {
        $this->_resource->save($entity);
        return $this;
    }

    /**
     * @param LinkInterface $entity
     * @return $this
     */
    public function delete(LinkInterface $entity)
    {
        $this->_resource->delete($entity);
        return $this;
    }

    /**
     * @param string $serviceCode
     * @param string $giftCardCode
     * @return LinkInterface
     * @throws NoSuchEntityException
     */
    public function getGiftCardDataByServiceAndCode($serviceCode, $giftCardCode)
    {
        $entity = $this->_factory->create();
        $this->_resource->loadByServiceAndCode($entity, $serviceCode, $giftCardCode);
        if ($entity->getId() === null) {
            throw new NoSuchEntityException(__('Requested link doesn\'t exist'));
        }
        return $entity;
    }
}
