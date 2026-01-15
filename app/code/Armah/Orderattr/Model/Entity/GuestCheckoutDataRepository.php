<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Entity;

use Armah\Orderattr\Api\Data\EntityDataInterface;
use Armah\Orderattr\Api\GuestCheckoutDataRepositoryInterface;
use Armah\Orderattr\Api\CheckoutDataRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\QuoteRepository;

class GuestCheckoutDataRepository implements GuestCheckoutDataRepositoryInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * @var CheckoutDataRepositoryInterface
     */
    private $repository;

    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        QuoteRepository $quoteRepository,
        CheckoutDataRepositoryInterface $repository
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->repository = $repository;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @inheritdoc
     */
    public function save(
        $armahCartId,
        $checkoutFormCode,
        $shippingMethodCode,
        EntityDataInterface $entityData
    ) {
        if ($parentId = $this->quoteIdMaskFactory->create()->load($armahCartId, 'masked_id')->getQuoteId()) {
            try {
                $quote = $this->quoteRepository->get($parentId);

                return $this->repository->save($parentId, $checkoutFormCode, $shippingMethodCode, $entityData);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                throw new \Magento\Framework\Exception\InputException(__('Quote doesn\'t exist.'));
            }
        }

        throw new \Magento\Framework\Exception\InputException(__('Quote doesn\'t exist.'));
    }
}
