<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 21:30
 */

namespace Conneqt\SpecialPrices\Pricing\Price;

use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\Price\BasePriceProviderInterface;

class SpecialPrice extends AbstractPrice implements BasePriceProviderInterface
{
    const PRICE_CODE = 'conneqt_special_price';

    protected $customerSession;

    protected $specialPriceCalculator;

    public function __construct(
        \Magento\Framework\Pricing\SaleableInterface $saleableItem,
        $quantity,
        \Magento\Framework\Pricing\Adjustment\CalculatorInterface $calculator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Customer\Model\Session $customerSession,
        \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface $specialPriceCalculator
    ) {
        parent::__construct($saleableItem, $quantity, $calculator, $priceCurrency);

        $this->customerSession = $customerSession;
        $this->specialPriceCalculator = $specialPriceCalculator;
    }

    /**
     * Get price value in display currency
     *
     * @return float|bool
     */
    public function getValue()
    {
        $customerId = $this->customerSession->isLoggedIn() ? $this->customerSession->getCustomerId() : null;

        return $this->specialPriceCalculator->calculate(
            $this->getProduct()->getId(),
            $customerId,
            $this->getProduct()->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\BasePrice::PRICE_CODE)->getValue(),
            $this->getQuantity()
        );
    }
}