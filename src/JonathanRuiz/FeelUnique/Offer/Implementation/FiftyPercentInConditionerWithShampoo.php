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
        $products = [];
        $maximumToApplyOffer = 0;

        foreach ($order->getDistinctCategories() as $category) {
            switch ($category->getName()) {
                case self::SHAMPOO_NAME:
                    $maximumToApplyOffer = count($category->getProducts());
                    break;
                case self::CONDITIONER_NAME:
                    $products = $category->getProductsOrderedByPrice();
                    break;
            }
        }

        $elementsToApply = (count($products) < $maximumToApplyOffer) ? count($products) : $maximumToApplyOffer;

        for ($i = 0; $i < $elementsToApply; $i++) {
            /** @var Product $product */
            $product = $products[$i];

            $product->flagAsAppliedOffer();
            $order->takeFromTotalPrice($product->getPrice() / 2);
        }

        return $order;
    }
}
