<?php

namespace Conneqt\SpecialPrices\Helper;

class Cache extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->getValue('conneqt_specialprices/caching/enabled') == 1;
    }

    private function getCacheTtl()
    {
        $ttl = $this->scopeConfig->getValue('conneqt_specialprices/caching/ttl');

        if (empty($ttl)) {
            return 3600;
        }

        return $ttl;
    }

    public function getRedisClient()
    {
        return new \Credis_Client(
            $this->scopeConfig->getValue('conneqt_specialprices/caching/redis_host'),
            $this->scopeConfig->getValue('conneqt_specialprices/caching/redis_port'),
            null,
            '',
            $this->scopeConfig->getValue('conneqt_specialprices/caching/redis_database')
        );
    }

    public function getKeys($prefix)
    {
        return $this->getRedisClient()->keys($prefix . '*');
    }

    public function delete($key)
    {
        return $this->getRedisClient()->del($key);
    }

    public function getValue($key)
    {
        return $this->getRedisClient()->get($key);
    }

    public function setValue($key, $value)
    {
        return $this->getRedisClient()->set($key, $value, ['EX' => $this->getCacheTtl()]);
    }
}
