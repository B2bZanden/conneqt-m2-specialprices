<?php

namespace Conneqt\SpecialPrices\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonResultFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var \Magento\Framework\Pricing\Render
     */
    private $priceRenderer;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        parent::__construct($context);
        $this->jsonResultFactory = $jsonResultFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $priceRender = $this->_view->getLayout()->createBlock(
            \Magento\Framework\Pricing\Render::class,
            'product.price.render.default',
            ['data' => ['price_render_handle' => 'catalog_product_prices']]
        );

        $productIds = $this->getRequest()->getParam('p');
        $response = $this->jsonResultFactory->create();
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0', true);

        if ($productIds) {
            $productCollection = $this->productCollectionFactory->create()
                ->addIdFilter($productIds);

            $productPriceHtml = [];

            /** @var \Magento\Catalog\Model\Product $product */
            foreach ($productCollection as $product) {
                /** Force cache busting on block */
                $product->setData('customer_group_id', microtime(true));

                $productPriceHtml[$product->getId()] = $priceRender->render(
                    \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                    $product,
                    [
                        'include_container' => true,
                        'display_minimal_price' => true,
                        'zone' => \Magento\Framework\Pricing\Render::ZONE_DEFAULT,
                        'list_category_page' => true
                    ]
                );
            }

            $response->setData(['prices' => $productPriceHtml]);
        } else {
            $response->setData(['error' => 'No product ids in request']);
        }

        return $response;
    }
}
