<?php

namespace JonathanRuiz\FeelUnique\Offer\Implementation;

use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Offer\Offer;

/**
 * If you buy shampoo + conditioner, you get a 50% discount
 */
class FiftyPercentInConditionerWithShampoo implements Offer {
    const SHAMPOO_NAME = 'Shampoo';
    const CONDITIONER_NAME = 'Conditioner';

    /**
     * Unique identifier for the offer
     * @return string
     */
    public function getName() {
        return '50%';
    }

    /**
     * Applies the offer and returns the new price
     * @param Order $order
     * @return Order
     */
    public function applyFor(Order $order) {
        $categoryProducts = [];

        foreach ($order->getDistinctCategories() as $category) {
            switch ($category->getName()) {
                case self::SHAMPOO_NAME:
                    $categoryProducts[] = $category->getProductsOrderedByPrice();
                    break;
                case self::CONDITIONER_NAME:
                    $categoryProducts[] = $category->getProductsOrderedByPrice();
                    break;
            }
        }

        if (count($categoryProducts) === 2) {
            $minLength = (count($categoryProducts[0]) > count($categoryProducts[1])) ? count($categoryProducts[1]) : count($categoryProducts[0]);

            foreach ($categoryProducts as $categoryProduct) {
                /** @var Product $product */
                foreach ($categoryProduct as $i => $product) {
                    if ($i < $minLength) {
                        $order->takeFromTotalPrice($product->getPrice() / 2);
                    }
                }
            }
        }

        return $order;
    }
}
