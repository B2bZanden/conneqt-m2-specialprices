<?php

namespace Conneqt\SpecialPrices\Model;

class CalculateRequest extends \Magento\Framework\DataObject implements \Conneqt\SpecialPrices\Api\Data\CalculateRequestInterface
{
    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->setData('customer_id', $customerId);
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->getData('product_id');
    }

    /**
     * @param int $productId
     */
    public function setProductId($productId)
    {
        $this->setData('product_id', $productId);
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getData('quantity');
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->setData('quantity', $quantity);
    }
}
