<?php

namespace Conneqt\SpecialPrices\Block;

class Script extends \Magento\Framework\View\Element\Template
{
    public function getAjaxUrl()
    {
        return $this->getUrl('pricing');
    }
}