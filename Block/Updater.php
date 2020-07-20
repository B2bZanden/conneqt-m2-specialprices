<?php

namespace Conneqt\SpecialPrices\Block;

class Updater extends \Magento\Catalog\Block\Product\View
{
    private $_product;

    protected $_template = 'updater.phtml';

    public function setProduct($product)
    {
        $this->_product = $product;
        return $this;
    }

    public function getProduct()
    {
        return $this->_product;
    }
}
