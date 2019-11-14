<?php

namespace Conneqt\SpecialPrices\Plugin;

class ModifyFinalPrice
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface
     */
    private $specialPriceCalculator;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface $specialPriceCalculator
    ) {
        $this->customerSession = $customerSession;
        $this->specialPriceCalculator = $specialPriceCalculator;
    }

    public function afterGetValue(\Magento\Catalog\Pricing\Price\FinalPrice $subject, $result)
    {
        $customerId = $this->customerSession->isLoggedIn() ? $this->customerSession->getCustomerId() : null;

        return $this->specialPriceCalculator->calculate(
            $subject->getProduct()->getId(),
            $customerId,
            $subject->getProduct()->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\BasePrice::PRICE_CODE)->getValue(),
            $subject->getQuantity());
    }
}
