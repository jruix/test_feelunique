<?php

namespace JonathanRuiz\FeelUnique\Tests\Offer\Implementation;

use JonathanRuiz\FeelUnique\Model\Category;
use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Offer\Implementation\GetThreePayTwo;

class GetThreePayTwoTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider orderProvider
     */
    public function testApplyMethod(Order $order, $expected) {
        $offer = new GetThreePayTwo();
        $order = $offer->applyFor($order);

        $this->assertEquals($expected, $order->getTotalPrice());
    }

    public function orderProvider() {
        $category1 = new Category('C1');
        $category2 = new Category('C2');

        $product1 = new Product('P1', 2, $category1);
        $product2 = new Product('P2', 6, $category1);
        $product3 = new Product('P3', 8, $category1);

        $product4 = new Product('P4', 8, $category2);
        $product5 = new Product('P5', 15, $category2);

        $category1->addProduct($product1);
        $category1->addProduct($product2);
        $category1->addProduct($product3);

        $category2->addProduct($product4);
        $category2->addProduct($product5);

        $order1 = new Order();
        $order1->add($product1);
        $order1->add($product2);
        $order1->add($product3);

        $order1->setTotalPrice(16);

        $order2 = new Order();
        $order2->add($product4);
        $order2->add($product5);

        $order2->setTotalPrice(23);

        return [
            [$order1, 14],
            [$order2, 23]
        ];
    }
}
