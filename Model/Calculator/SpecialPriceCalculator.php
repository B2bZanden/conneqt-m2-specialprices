<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 20:20
 */

namespace Conneqt\SpecialPrices\Model\Calculator;

class SpecialPriceCalculator implements \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface
{
    protected $_collectionFactory;

    protected $_productRepository;

    public function __construct(
        \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\CollectionFactory $collectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_productRepository = $productRepository;
    }

    /**
     * Recalculates the price for a product
     *
     * @param $productId int
     * @param $customerId int
     * @param $qty int
     * @return double
     */
    public function calculate($productId, $customerId, $qty)
    {
        $basePrice = $this->_productRepository->getById($productId)->getPrice();

        $productSpecialPriceCollection = $this->_collectionFactory->create()
                                                        ->addFieldToFilter('product_id', ['eq' => $productId])
                                                        ->addFieldToFilter('customer_id', ['null' => true]);

        $customerSpecialPriceCollection = $this->_collectionFactory->create()
                                                        ->addFieldToFilter('customer_id', ['eq' => $customerId])
                                                        ->addFieldToFilter('product_id', ['null' => true]);

        $customerProductSpecialPriceCollection = $this->_collectionFactory->create()
                                                        ->addFieldToFilter('product_id', ['eq' => $productId])
                                                        ->addFieldToFilter('customer_id', ['eq' => $customerId]);

        /** @var \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPriceRuleToExecute */
        $specialPriceRuleToExecute = null;

        if ($customerProductSpecialPriceCollection->getSize() > 0) {
            $specialPriceRuleToExecute = $customerProductSpecialPriceCollection->getFirstItem();
        } else if ($customerSpecialPriceCollection->getSize() > 0) {
            $specialPriceRuleToExecute = $customerSpecialPriceCollection->getFirstItem();
        } else if ($productSpecialPriceCollection->getSize() > 0) {
            $specialPriceRuleToExecute = $productSpecialPriceCollection->getFirstItem();
        }

        if (false === is_null($specialPriceRuleToExecute)) {
            /**
             * Fixed price
             */
            if ($specialPriceRuleToExecute->getType() === \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface::TYPE_FIXED_PRICE) {
                return doubleval($specialPriceRuleToExecute->getValue());
            }

            /**
             * Discount percentage
             */
            if ($specialPriceRuleToExecute->getType() === \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface::TYPE_DISCOUNT_PERCENTAGE) {
                return doubleval($basePrice - ($basePrice / 100 * $specialPriceRuleToExecute->getValue()));
            }

            /**
             * Discount amount
             */
            if ($specialPriceRuleToExecute->getType() === \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface::TYPE_DISCOUNT_AMOUNT) {
                return doubleval($basePrice - $specialPriceRuleToExecute->getValue());
            }
        }

        return $basePrice;
    }
}