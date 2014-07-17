<?php

namespace JonathanRuiz\FeelUnique\Offer;

use JonathanRuiz\FeelUnique\Offer\Exception\InvalidOfferTypeException;
use JonathanRuiz\FeelUnique\Offer\Implementation\FiftyPercentInConditionerWithShampoo;
use JonathanRuiz\FeelUnique\Offer\Implementation\GetThreePayTwo;

/**
 * Factory offer creator, based on the offer name
 */
class OfferFactory {
    /**
     * @param $offerName
     * @return Offer
     * @throws InvalidOfferTypeException
     */
    public static function create($offerName) {
        $validOffers = [
            new GetThreePayTwo(),
            new FiftyPercentInConditionerWithShampoo()
        ];

        /** @var Offer $offer  */
        foreach ($validOffers as $offer) {
            if ($offer->getName() === $offerName) {
                return $offer;
            }
        }

        throw new InvalidOfferTypeException;
    }
}
