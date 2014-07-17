<?php

namespace JonathanRuiz\FeelUnique\Parser;

use JonathanRuiz\FeelUnique\Model\Order;

/**
 * Interface for parsers (we could have XML, JSON, CSV...)
 */
interface ParserInterface {
    /**
     * @return Order
     */
    public function parse();
} 