<?php

namespace Conneqt\SpecialPrices\Plugin;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\AbstractBlock;

class RemoveBlockWhenDisabled
{
    const BLOCK_NAME = 'conneqt.specialprice.container';

    const CONFIG_PATH = 'conneqt_specialprices/settings/active';

    private $_scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig) {
        $this->_scopeConfig = $scopeConfig;
    }

    public function afterToHtml(AbstractBlock $subject, $result)
    {
        if ($subject->getNameInLayout() === self::BLOCK_NAME && $this->_scopeConfig->getValue(self::CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE) === "0") {
            return '';
        }

        return $result;
    }
}
