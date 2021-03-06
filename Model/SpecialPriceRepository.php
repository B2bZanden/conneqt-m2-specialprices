<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 16-01-18
 * Time: 11:23
 */

namespace Conneqt\SpecialPrices\Model;

class SpecialPriceRepository implements \Conneqt\SpecialPrices\Api\SpecialPriceRepositoryInterface
{
    /** @var \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPriceFactory */
    protected $specialResourceModelFactory;
    private $_specialPriceFactory;
    private $_specialPriceCollectionFactory;
    private $_specialPriceSearchResultInterfaceFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;
    /**
     * @var \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface
     */
    private $specialPriceCalculator;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    public function __construct(
        SpecialPriceFactory $specialPriceFactory,
        \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\CollectionFactory $specialPriceCollectionFactory,
        \Conneqt\SpecialPrices\Api\Data\SpecialPriceSearchResultInterfaceFactory $specialPriceSearchResultInterfaceFactory,
        \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPriceFactory $specialResourceModelFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Conneqt\SpecialPrices\Api\SpecialPriceCalculatorInterface $specialPriceCalculator,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->_specialPriceFactory = $specialPriceFactory;
        $this->_specialPriceCollectionFactory = $specialPriceCollectionFactory;
        $this->_specialPriceSearchResultInterfaceFactory = $specialPriceSearchResultInterfaceFactory;
        $this->specialResourceModelFactory = $specialResourceModelFactory;
        $this->transactionFactory = $transactionFactory;
        $this->specialPriceCalculator = $specialPriceCalculator;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @param int $id
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $specialPrice = $this->_specialPriceFactory->create();
        $specialPrice->getResource()->load($specialPrice, $id);

        if (!$specialPrice->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Unable to find special price with ID "%1"', $id));
        }

        return $specialPrice;
    }

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface
     */
    public function save(\Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice)
    {
        $specialPrice->getResource()->save($specialPrice);

        return $specialPrice;
    }

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice
     * @return void
     */
    public function delete($id)
    {
        /** @var \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice $specialResourceModel */
        $specialResourceModel = $this->specialResourceModelFactory->create();
        $specialPrice = $this->_specialPriceFactory->create();

        $specialResourceModel->load($specialPrice, $id);
        $specialResourceModel->delete($specialPrice);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->_specialPriceCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, \Conneqt\SpecialPrices\Model\ResourceModel\SpecialPrice\Collection $collection)
    {
        $searchResults = $this->_specialPriceSearchResultInterfaceFactory->create();

        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface[] $specialPrices
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface[]
     */
    public function bulkUpdate(array $specialPrices)
    {
        $transaction = $this->transactionFactory->create();

        foreach ($specialPrices as $specialPrice) {
            $transaction->addObject($specialPrice);
        }

        $transaction->save();

        return $specialPrices;
    }

    /**
     * @param int[] $specialPriceIds
     * @return bool
     */
    public function bulkDelete(array $specialPriceIds)
    {
        $specialPricesToDelete = $this->_specialPriceCollectionFactory->create()
                                            ->addFieldToFilter('entity_id', ['in' => $specialPriceIds]);

        try {
            $specialPricesToDelete->walk('delete');
        } catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\CalculateRequestInterface $calculateRequest
     * @return double
     */
    public function calculate(\Conneqt\SpecialPrices\Api\Data\CalculateRequestInterface $calculateRequest)
    {
        $productModel = $this->productCollectionFactory->create()
            ->removeAllFieldsFromSelect()
            ->addAttributeToSelect('price')
            ->addIdFilter($calculateRequest->getProductId())->getFirstItem();

        if ($productModel->getId()) {
            return $this->specialPriceCalculator->calculate($calculateRequest->getProductId(), $calculateRequest->getCustomerId(), $productModel->getData('price'), $calculateRequest->getQuantity());
        } else {
            return 0;
        }
    }
}
