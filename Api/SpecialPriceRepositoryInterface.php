<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 16-01-18
 * Time: 11:19
 */

namespace Conneqt\SpecialPrices\Api;

interface SpecialPriceRepositoryInterface
{
    /**
     * @param int $id
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface
     */
    public function save(\Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice);

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice
     * @return void
     */
    public function delete(\Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface $specialPrice);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}