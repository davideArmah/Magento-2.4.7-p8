<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model;

use Armah\CrossLinks\Api\LinkInterface;

/**
 * Class LinkFactory
 * @package Armah\CrossLinks\Model
 */
class LinkFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    /**
     * @param array $data
     * @return \Armah\CrossLinks\Api\LinkInterface
     * @throws \UnexpectedValueException
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create(LinkInterface::class, $data);
    }

    /**
     * @param array $data
     * @return \Armah\CrossLinks\Api\LinkInterface
     * @throws \UnexpectedValueException
     */
    public function get()
    {
        return $this->_objectManager->get(LinkInterface::class);
    }

}
