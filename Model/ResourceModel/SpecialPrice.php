<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 17:16
 */

namespace Conneqt\SpecialPrices\Model\ResourceModel;

class SpecialPrice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('conneqt_specialprices', 'entity_id');
    }

}