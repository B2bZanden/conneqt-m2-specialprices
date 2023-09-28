<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-01-18
 * Time: 20:16
 */

namespace Conneqt\SpecialPrices\Observer\Catalog\Product;

class PriceObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $customerSession;
	protected $storeManagerInterface;
	protected $state;
	protected $userContext;
	protected $specialPriceCalculator;

	public function __construct(
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
		\Magento\Framework\App\State $state,
		\Magento\Authorization\Model\UserContextInterface $userContext,
		\Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface $specialPriceCalculator
	) {
		$this->customerSession = $customerSession;
		$this->storeManagerInterface = $storeManagerInterface;
		$this->state = $state;
		$this->userContext = $userContext;
		$this->specialPriceCalculator = $specialPriceCalculator;
	}

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getData('product');
        $qty = $observer->getData('qty');

        $customerId = $this->customerSession->isLoggedIn() ? $this->customerSession->getCustomerId() : null;

	    if(!isset($customerId)) {
		    $storeId = $this->storeManagerInterface->getStore()->getStoreId();
		    $areaCode = $this->state->getAreaCode(); // webapi_rest
		    if(($storeId > 1) && ($areaCode === 'webapi_rest')) {
			    try {
				    $customerId = $this->userContext->getUserId();
			    } catch (\Exception $e) {
				    // just catch
			    }
		    }
	    }

        $finalPrice = $this->specialPriceCalculator->calculate(
            $product->getId(),
            $customerId,
            $product->getData('price'),
            $qty
        );

        $product->setData('final_price', $finalPrice);
    }
}
