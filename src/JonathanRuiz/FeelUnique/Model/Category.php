<?php

namespace JonathanRuiz\FeelUnique\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category handler
 */
class Category {
    /**
     * @var string
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $products;

    /**
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
        $this->products = new ArrayCollection();
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
     * @param Product $product
     */
    public function addProduct(Product $product) {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    /**
     * @return Product[]
     */
    public function getProducts() {
        return $this->products->toArray();
    }

    /**
     * @return Product[]
     */
    public function getProductsOrderedByPrice() {
        $products = $this->products->toArray();
        usort($products, function(Product $a, Product $b) {
            if ($a->getPrice() === $b->getPrice()) {
                return 0;
            }
            return ($a->getPrice() < $b->getPrice()) ? -1 : 1;
        });

        return $products;
    }
}
