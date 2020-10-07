<?php

namespace Conneqt\SpecialPrices\Controller\Adminhtml\Cache;

class Invalidate extends \Magento\Backend\App\Action
{
    /**
     * @var \Conneqt\SpecialPrices\Helper\Cache
     */
    private $cache;

    /**
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $redirectFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Conneqt\SpecialPrices\Helper\Cache $cache,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);

        $this->cache = $cache;
        $this->messageManager = $messageManager;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $keys = $this->cache->getKeys('conneqt_sp');

        foreach ($keys as $key) {
            $this->cache->delete($key);
        }

        $this->messageManager->addSuccessMessage(__('Successfully purged %1 price results', count($keys)));

        $redirect = $this->redirectFactory->create();
        $redirect->setRefererUrl();

        return $redirect;
    }
}
