<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\ResourceModel\Link;

/**
 * Factory class for @see \Armah\CrossLinks\Model\ResourceModel\Link\Collection
 */
class CollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * CollectionFactory constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Armah\CrossLinks\Model\ResourceModel\Link\Collection
     */
    public function create(array $data = array())
    {
        return $this->objectManager->create(Collection::class, $data);
    }

    /**
     * @return \Armah\CrossLinks\Model\ResourceModel\Link\Collection
     */
    public function get()
    {
        return $this->objectManager->get(Collection::class);
    }
}
