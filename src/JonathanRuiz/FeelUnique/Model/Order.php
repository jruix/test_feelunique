<?php

namespace JonathanRuiz\FeelUnique\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order handler; implements IteratorAggregate to be able to loop over
 * the collection of products, and Countable to be able to do a
 * "count" over the collection of products
 */
class Order implements \IteratorAggregate, \Countable {
    /**
     * @var ArrayCollection
     */
    private $products;

    /**
     * @var float
     */
    private $totalPrice;

    public function __construct() {
        $this->products = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getTotalPrice() {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param float $quantity
     */
    public function takeFromTotalPrice($quantity) {
        $this->totalPrice -= $quantity;
    }

    /**
     * @param Product $product
     */
    public function add(Product $product) {
        $this->products->add($product);
    }

    /**
     * @return Product[]
     */
    public function getProducts() {
        return $this->products->toArray();
    }

    /**
     * @return Category[]
     */
    public function getDistinctCategories() {
        $categories = [];
        /** @var Product $product */
        foreach ($this->products as $product) {
            if (!in_array($product->getCategory(), $categories)) {
                $categories[] = $product->getCategory();
            }
        }

        return $categories;
    }

    public function getIterator() {
        return new \ArrayIterator($this->products->toArray());
    }

    public function count() {
        return $this->products->count();
    }
}
