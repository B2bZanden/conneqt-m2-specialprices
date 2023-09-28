<?php

namespace Conneqt\SpecialPrices\Block;

class Script extends \Magento\Framework\View\Element\Template
{
    public function getAjaxUrl()
    {
        return $this->getUrl('pricing');
    }

	public function isModuleEnabledForStore()
	{
		return $this->_scopeConfig->getValue('conneqt_specialprices/settings/active', \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE) !== "0";
	}
}
