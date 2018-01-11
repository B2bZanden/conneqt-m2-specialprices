<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:16
 */

namespace Conneqt\SpecialPrices\Model;

/**
 * @method \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice getResource()
 * @method \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\Collection getCollection()
 */
class SpecialPrice extends \Magento\Framework\Model\AbstractModel implements \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'conneqt_specialprices_specialprice';
    protected $_cacheTag = 'conneqt_specialprices_specialprice';
    protected $_eventPrefix = 'conneqt_specialprices_specialprice';

    protected function _construct()
    {
        $this->_init('Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID of Product
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set ID of product
     *
     * @param $id int
     * @return $this
     */
    public function setProductId($id)
    {
        $this->setData(self::PRODUCT_ID, $id);

        return $this;
    }

    /**
     * Get Entity Id of Customer
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ENTITY_ID);
    }

    /**
     * Set Entity Id of Customer
     *
     * @param $customerId int
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ENTITY_ID, $customerId);

        return $this;
    }

    /**
     * Get Type of Special Price
     *
     * @return int
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set type of Special Price
     *
     * @param $type int
     * @return $this
     */
    public function setType($type)
    {
        $this->setData(self::TYPE, $type);

        return $this;
    }

    /**
     * Get value of Special Price
     *
     * @return double
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**
     * Set Value of Special Price
     *
     * @param $value double
     * @return $this
     */
    public function setValue($value)
    {
        $this->setData(self::VALUE, $value);

        return $this;
    }
}