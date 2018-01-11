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

    public function __construct(
        \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\CollectionFactory $collectionFactory
    ) {
        $this->_collectionFactory = $collectionFactory;
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
        return doubleval(1);
    }
}