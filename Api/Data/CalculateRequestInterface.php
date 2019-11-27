<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:06
 */

namespace Conneqt\SpecialPrices\Api\Data;

interface CalculateRequestInterface
{
    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param int $productId
     */
    public function setProductId($productId);

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity);
}
