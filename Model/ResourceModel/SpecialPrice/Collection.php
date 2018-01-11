<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:16
 */

namespace Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';


    protected function _construct()
    {
        $this->_init('Conneqt\SpecialPrices\Model\SpecialPrice', 'Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice');
    }

}