<?php

namespace JonathanRuiz\FeelUnique\Offer\Implementation;

use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Offer\Offer;

/**
 * Get a 3x2 offer on products
 */
class GetThreePayTwo implements Offer {
    const NUMBER_OF_PRODUCTS = 3;

    /**
     * Unique identifier for the offer
     * @return string
     */
    public function getName() {
        return '3x2';
    }

    /**
     * Applies the offer and returns the new price
     * @param Order $order
     * @return Order
     */
    public function applyFor(Order $order) {
        foreach ($order->getDistinctCategories() as $category) {
            $quantityOfProducts = count($category->getProducts());
            $productsToTakeFrom = floor($quantityOfProducts / self::NUMBER_OF_PRODUCTS);

            if ($productsToTakeFrom > 0) {
                $products = $category->getProductsOrderedByPrice();

                for ($i = 0; $i < $productsToTakeFrom; $i++) {
                    $products[$i]->flagAsAppliedOffer();
                    $order->takeFromTotalPrice($products[$i]->getPrice());
                }
            }
        }

        return $order;
    }
}
