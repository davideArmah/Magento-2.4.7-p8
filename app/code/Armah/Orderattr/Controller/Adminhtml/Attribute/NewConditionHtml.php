<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Controller\Adminhtml\Attribute;

use Armah\Orderattr\Model\Rule\RuleFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Rule\Model\Condition\AbstractCondition;

class NewConditionHtml extends Action
{
    public const CONDITION_TYPE = 0;
    public const CONDITION_ATTR = 1;

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Armah_Orderattr::order_attributes';

    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    public function __construct(
        Context $context,
        RuleFactory $ruleFactory
    ) {
        parent::__construct($context);
        $this->ruleFactory = $ruleFactory;
    }

    public function execute()
    {
        $conditionId = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getPost('type')));
        $type = $typeArr[self::CONDITION_TYPE];

        if (empty($type) || !is_subclass_of($type, AbstractCondition::class)) {
            return;
        }
        $model = $this->_objectManager->create($type)
            ->setId($conditionId)
            ->setType($type)
            ->setRule($this->ruleFactory->create())
            ->setPrefix('conditions');

        if (!empty($typeArr[self::CONDITION_ATTR])) {
            $model->setAttribute($typeArr[self::CONDITION_ATTR]);
        }

        if ($model instanceof AbstractCondition) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }

        return $this->getResponse()->setBody($html);
    }
}
