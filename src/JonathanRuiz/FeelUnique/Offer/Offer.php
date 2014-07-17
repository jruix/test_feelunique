<?php

namespace JonathanRuiz\FeelUnique\Offer;

use JonathanRuiz\FeelUnique\Model\Order;

/**
 * Interface for an offer
 */
interface Offer {
    /**
     * Applies the offer and returns the new price
     * @param Order $order
     * @return Order
     */
    public function applyFor(Order $order);

    /**
     * Unique identifier for the offer
     * @return string
     */
    public function getName();
}
