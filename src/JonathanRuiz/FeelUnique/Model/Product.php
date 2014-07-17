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
     * @param $name
     * @param $price
     * @param Category $category
     */
    public function __construct($name, $price, Category $category) {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
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
}
