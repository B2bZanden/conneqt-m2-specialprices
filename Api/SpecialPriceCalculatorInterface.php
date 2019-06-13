<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 20:18
 */

namespace Conneqt\SpecialPrices\Api;

interface SpecialPriceCalculatorInterface
{
    /**
     * Recalculates the price for a product
     *
     * @param $productId int
     * @param $customerId int
     * @param $basePrice double
     * @param $qty int
     * @return double
     */
    public function calculate($productId, $customerId, $basePrice, $qty);
}