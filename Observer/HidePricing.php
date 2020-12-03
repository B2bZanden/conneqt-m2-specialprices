<?php

namespace Conneqt\SpecialPrices\Observer;

class HidePricing implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;
    private $moduleManager;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->request = $request;
        $this->moduleManager = $moduleManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->moduleManager->isOutputEnabled('Conneqt_SpecialPrices')) {
            return;
        }

        if ($this->request->getModuleName() === 'pricing' || ($this->request->getModuleName() === 'searchautocomplete' && $this->request->getActionName() === 'suggest')) {
            return;
        }

        /** @var \Magento\Framework\Pricing\Render\PriceBox $block */
        $block = $observer->getData('block');
        if (in_array(\Magento\Framework\Pricing\Render\PriceBox::class, class_parents($block))) {
            $transport = $observer->getData('transport');
            $html = $transport->getData('html');

            \preg_match('/(\<div[^>]+>).+(<\/div>)/s', $html, $output);
            unset($output[0]);

            $transport->setData('html', \implode(__('Loading...'), $output));
        }
    }
}
