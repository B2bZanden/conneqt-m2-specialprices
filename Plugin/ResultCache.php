<?php

namespace Conneqt\SpecialPrices\Plugin;

class ResultCache
{
    /**
     * @var \Conneqt\SpecialPrices\Helper\Cache
     */
    private $cache;

    public function __construct(\Conneqt\SpecialPrices\Helper\Cache $cache)
    {
        $this->cache = $cache;
    }

    public function aroundCalculate($subject, callable $proceed, $productId, $customerId, $basePrice, $qty)
    {
        $cacheKey = sprintf('conneqt_sp_%s_%s_%s_%s', $productId, $customerId, $basePrice, $qty);
        if ($this->cache->isEnabled()) {
            if ($result = $this->cache->getValue($cacheKey)) {
                return $result;
            }
        }

        $result = $proceed($productId, $customerId, $basePrice, $qty);

        if ($this->cache->isEnabled()) {
            $this->cache->setValue($cacheKey, $result);
        }

        return $result;
    }
}
