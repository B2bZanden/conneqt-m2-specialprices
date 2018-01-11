<?php
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 16-10-17
 * Time: 21:45
 */

namespace Conneqt\SpecialPrices\Api\Data;

interface SpecialPriceSearchResultInterface
{
    /**
     * @return \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface[]
     */
    public function getItems();

    /**
     * @param \Conneqt\SpecialPrices\Api\Data\SpecialPriceInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}