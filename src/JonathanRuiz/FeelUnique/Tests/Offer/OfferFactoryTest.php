<?php

namespace JonathanRuiz\FeelUnique\Tests\Offer;

use JonathanRuiz\FeelUnique\Offer\OfferFactory;

class OfferFactoryTest extends \PHPUnit_Framework_TestCase {
    public function testFactory_exceptionIsThrownForUnknownOffer() {
        $this->setExpectedException('JonathanRuiz\FeelUnique\Offer\Exception\InvalidOfferTypeException');

        OfferFactory::create('FAKE');
    }

    public function testFactoryMethod() {
        $offer = OfferFactory::create('3x2');
        $this->assertInstanceOf('JonathanRuiz\FeelUnique\Offer\Implementation\GetThreePayTwo', $offer);

        $offer = OfferFactory::create('50%');
        $this->assertInstanceOf('JonathanRuiz\FeelUnique\Offer\Implementation\FiftyPercentInConditionerWithShampoo', $offer);
    }
}
