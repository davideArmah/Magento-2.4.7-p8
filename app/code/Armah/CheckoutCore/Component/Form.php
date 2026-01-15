<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Component;

use Magento\Ui\Component\Form as UiFrom;

class Form extends UiFrom
{
    /**
     * {@inheritdoc}
     */
    public function getDataSourceData()
    {
        return $this->getContext()->getDataProvider()->getData();
    }
}
