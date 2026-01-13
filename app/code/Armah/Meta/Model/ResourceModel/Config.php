<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */
namespace Armah\Meta\Model\ResourceModel;

class Config extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function _construct()
    {
        $this->_init('armah_meta_config', 'config_id');
    }

}
