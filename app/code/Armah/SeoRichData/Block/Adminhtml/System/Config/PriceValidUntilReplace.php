<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;

class PriceValidUntilReplace extends Field
{
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    public function __construct(
        ProductMetadataInterface $productMetadata,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productMetadata = $productMetadata;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        if ($this->productMetadata->getEdition() === ProductMetadata::EDITION_NAME) {
            $result = parent::render($element);
        } else {
            $result = '';
        }

        return $result;
    }
}
