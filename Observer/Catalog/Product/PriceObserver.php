<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 20:16
 */

namespace Conneqt\SpecialPrices\Observer\Catalog\Product;

class PriceObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $customerSession;
    protected $specialPriceCalculator;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface $specialPriceCalculator
    ) {
        $this->customerSession = $customerSession;
        $this->specialPriceCalculator = $specialPriceCalculator;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getData('product');
        $qty = $observer->getData('qty');

        $customerId = $this->customerSession->isLoggedIn() ? $this->customerSession->getCustomerId() : null;

        $finalPrice = $this->specialPriceCalculator->calculate(
            $product->getId(),
            $customerId,
            $product->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\BasePrice::PRICE_CODE)->getValue(),
            $qty
        );

        $product->setData('final_price', $finalPrice);
    }
}