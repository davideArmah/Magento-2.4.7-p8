<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Order;

use Magento\Backend\Model\Session;

class Storage
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @param $orderIds
     * @return $this
     */
    public function setOrderIds($orderIds)
    {
        $this->session->setOrderIds($orderIds);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderIds()
    {
        return $this->session->getOrderIds();
    }
}
