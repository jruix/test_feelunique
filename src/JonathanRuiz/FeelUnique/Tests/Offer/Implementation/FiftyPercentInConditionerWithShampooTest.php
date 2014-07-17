<?php

namespace JonathanRuiz\FeelUnique\Tests\Offer\Implementation;

use JonathanRuiz\FeelUnique\Model\Category;
use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Offer\Implementation\FiftyPercentInConditionerWithShampoo;

class FiftyPercentInConditionerWithShampooTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider orderProvider
     */
    public function testApplyMethod(Order $order, $expected) {
        $offer = new FiftyPercentInConditionerWithShampoo();
        $order = $offer->applyFor($order);

        $this->assertEquals($expected, $order->getTotalPrice());
    }

    public function orderProvider() {
        $category1 = new Category('Shampoo');
        $category2 = new Category('Conditioner');

        $product1 = new Product('P1', 2, $category1);
        $product2 = new Product('P2', 6, $category2);

        $product3 = new Product('P4', 8, $category2);
        $product4 = new Product('P5', 15, $category2);

        $order1 = new Order();
        $order1->add($product1);
        $order1->add($product2);

        $order2 = new Order();
        $order2->add($product3);
        $order2->add($product4);

        return [
            [$order1, 5],
            [$order2, 23]
        ];
    }
}
