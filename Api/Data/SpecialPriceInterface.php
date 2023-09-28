<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:06
 */

namespace Conneqt\SpecialPrices\Api\Data;

interface SpecialPriceInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const PRODUCT_ID = 'product_id';
    const CUSTOMER_ENTITY_ID = 'customer_id';
    const TYPE = 'type';
    const VALUE = 'value';

    const TYPE_FIXED_PRICE = 0;
    const TYPE_DISCOUNT_PERCENTAGE = 1;
    const TYPE_DISCOUNT_AMOUNT = 2;

    /**
     * Get Entity Id of Special Price
     *
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get ID of Product
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set ID of product
     *
     * @param $id int
     * @return $this
     */
    public function setProductId($id);

    /**
     * Get Entity Id of Customer
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Entity Id of Customer
     *
     * @param $customerId int
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Type of Special Price
     *
     * @return int
     */
    public function getType();

    /**
     * Set type of Special Price
     *
     * @param $type int
     * @return $this
     */
    public function setType($type);

    /**
     * Get value of Special Price
     *
     * @return double
     */
    public function getValue();

    /**
     * Set Value of Special Price
     *
     * @param $value double
     * @return $this
     */
    public function setValue($value);

    /**
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceExtensionInterface
     */
    public function getExtensionAttributes();

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Conneqt\SpecialPrices\Api\Data\SpecialPriceExtensionInterface $extensionAttributes);
}