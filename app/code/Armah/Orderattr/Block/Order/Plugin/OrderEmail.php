<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Order\Plugin;

use Armah\Orderattr\Block\Order\Attributes as OrderAttributes;
use Armah\Orderattr\Model\ConfigProvider;
use Armah\Orderattr\Model\OrderEmail\IsActionRelatedPdfAction;
use Magento\Sales\Block\Items\AbstractItems;
use Magento\Sales\Block\Order\Email\Invoice\Items as InvoiceItems;
use Magento\Sales\Block\Order\Email\Shipment\Items as ShipmentItems;

class OrderEmail
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var IsActionRelatedPdfAction
     */
    private $isActionRelatedPdfAction;

    public function __construct(
        ConfigProvider $configProvider,
        IsActionRelatedPdfAction $isActionRelatedPdfAction
    ) {
        $this->configProvider = $configProvider;
        $this->isActionRelatedPdfAction = $isActionRelatedPdfAction;
    }

    /**
     * @param AbstractItems $subject
     * @param string $result
     *
     * @return string
     */
    public function afterToHtml(AbstractItems $subject, string $result): string
    {
        $isPrintAllowed = true;

        if ($this->isActionRelatedPdfAction->execute()) {
            if ($subject instanceof InvoiceItems) {
                $isPrintAllowed = $this->configProvider->isIncludeToInvoicePdf();
            } elseif ($subject instanceof ShipmentItems) {
                $isPrintAllowed = $this->configProvider->isIncludeToShipmentPdf();
            }
        }

        /** @var OrderAttributes $attributesBlock */
        if ($isPrintAllowed
            && $attributesBlock = $subject->getChildBlock('order_attributes')
        ) {
            $result .= $attributesBlock->toHtml();
        }

        return $result;
    }
}
