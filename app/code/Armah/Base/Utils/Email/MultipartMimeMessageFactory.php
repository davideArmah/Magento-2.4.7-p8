<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Utils\Email;

use Magento\Framework\ObjectManagerInterface;

class MultipartMimeMessageFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $instanceName = null;

    public function __construct(
        ObjectManagerInterface $objectManager,
        $instanceName = MultipartMimeMessage::class
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    public function create(array $data = []): MultipartMimeMessage
    {
        return $this->objectManager->create($this->instanceName, $data);
    }
}
