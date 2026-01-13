<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Config\Backend;

use Armah\Base\Model\AdminNotification\Messages;
use Armah\Base\Model\Source\NotificationType;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\Data\ProcessorInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Unsubscribe extends Value implements ProcessorInterface
{
    public const PATH_TO_FEED_IMAGES = 'https://feed.armah.com/news/unsubscribe/';

    /**
     * @var Messages
     */
    private $messageManager;

    /**
     * @var NotificationType
     */
    private $notificationType;

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Messages $messageManager,
        NotificationType $notificationType,
        AbstractResource $resource,
        AbstractDb $resourceCollection,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->messageManager = $messageManager;
        $this->notificationType = $notificationType;
    }

    public function afterSave()
    {
        if ($this->isValueChanged()) {
            $this->prepareMessage();
        }

        return parent::afterSave();
    }

    private function prepareMessage()
    {
        $value = explode(',', $this->getValue());
        if (in_array(NotificationType::UNSUBSCRIBE_ALL, $value, true)) {
            $changes = [NotificationType::UNSUBSCRIBE_ALL];
        } else {
            $oldValue = explode(',', $this->getOldValue());
            $changes = array_diff($oldValue, $value);
            $changes = array_diff($changes, [NotificationType::UNSUBSCRIBE_ALL]);
        }

        if (!empty(array_filter($changes))) {
            foreach ($changes as $change) {
                $message = $this->generateMessage($change);
                $this->messageManager->addMessage($message);
            }
        } else {
            $this->messageManager->clear();
        }
    }

    /**
     * Process config value
     *
     * @param string $value
     * @return string
     */
    public function processValue($value)
    {
        return $value;
    }

    private function generateMessage($change)
    {
        $message = '';
        $titles = $this->notificationType->toOptionArray();
        foreach ($titles as $title) {
            if ($title['value'] === $change) {
                if ($change === NotificationType::UNSUBSCRIBE_ALL) {
                    $label = __('All Notifications');
                } else {
                    $label = $title['label'];
                }

                $message = '<img src="' . $this->generateLink($change) .'"/><span>'
                    . __('You have successfully unsubscribed from %1.', $label) .'</span>';
                break;
            }
        }

        return $message;
    }

    private function generateLink($change)
    {
        $change = mb_strtolower($change);
        return self::PATH_TO_FEED_IMAGES . $change . '.svg';
    }
}
