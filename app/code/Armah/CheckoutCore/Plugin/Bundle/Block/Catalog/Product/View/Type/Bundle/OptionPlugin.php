<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Bundle\Block\Catalog\Product\View\Type\Bundle;

use Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option;
use Magento\Catalog\Model\Product;

class OptionPlugin
{
    /**
     * Fix fatal on our checkout for magento 2.3.2 and 2.2.9
     * 'Call to a member function renderTierPrice() on null',
     * when bundle product in cart. Because catalog_product_view_type_bundle.xml set
     * argument tier_price_renderer, but on our checkout we dont use this layout.
     *
     * @param Option $subject
     */
    public function beforeGetData(
        Option $subject
    ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        if (class_exists(\Magento\Bundle\Block\DataProviders\OptionPriceRenderer::class)) {
            $optionPriceRenderer = $objectManager->get(\Magento\Bundle\Block\DataProviders\OptionPriceRenderer::class);
            $subject->setTierPriceRenderer($optionPriceRenderer);
        }
    }

    /**
     * @param Option $subject
     * @param Product $result
     * @return Product
     */
    public function afterGetProduct(
        Option $subject,
        $result
    ) {
        if ($subject->getParentBlock()
            && $subject->getParentBlock()->getNameInLayout() === 'archeckout.bundle.prototype'
        ) {
            return $subject->getParentBlock()->getProduct();
        }

        return $result;
    }
}
