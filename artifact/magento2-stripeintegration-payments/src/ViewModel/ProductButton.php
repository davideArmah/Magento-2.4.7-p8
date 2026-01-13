<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Hyva\StripeIntegrationPayments\ViewModel;

use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductButton implements ArgumentInterface
{

    /**
     * @var AssetRepository
     */
    private $assetRepository;

    public function __construct(AssetRepository $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    public function getAssetUrl($asset)
    {
        return $this->assetRepository->getUrl($asset);
    }

}
