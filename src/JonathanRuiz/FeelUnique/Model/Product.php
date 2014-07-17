<?php

namespace JonathanRuiz\FeelUnique\Model;

/**
 * Product handler
 */
class Product {
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var bool
     */
    private $appliedOffer = false;

    /**
     * @param $name
     * @param $price
     * @param Category $category
     */
    public function __construct($name, $price, Category $category) {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $category->addProduct($this);
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category) {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param float $price
     */
    public function setPrice($price) {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Marks the product as it has an offer applied
     */
    public function flagAsAppliedOffer() {
        $this->appliedOffer = true;
    }

    /**
     * @return bool
     */
    public function hasOfferApplied() {
        return $this->appliedOffer;
    }
}
