<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Offer\Offer;
use JonathanRuiz\FeelUnique\Offer\OfferFactory;
use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Manager\CategoryManager;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext {
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Offer
     */
    private $offer;

    /**
     * @var bool
     */
    private $applied = false;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {
    }

    /**
     * @Given /^the "([^"]*)" offer is enabled$/
     */
    public function theOfferIsEnabled($offerEnabled) {
        $this->offer = OfferFactory::create($offerEnabled);
    }

    /**
     * @Given /^the "([^"]*)" offer is disabled/
     */
    public function theOfferIsDisabled() {
        $this->offer = null;
    }

    /**
     * @When /^the following products are put on the order:$/
     */
    public function theFollowingProductsArePutOnTheOrder(TableNode $table) {
        $this->order = new Order();
        $categoryManager = new CategoryManager();

        foreach ($table->getRows() as $row) {
            $category = $categoryManager->create($row[0]);
            $this->order->add(new Product($row[1], $row[2], $category));
        }
    }

    /**
     * @Then /^I should get the "([^"]*)" for free$/
     */
    public function iShouldGetTheForFree($productName) {
        if (!$this->applied) {
            $this->offer->applyFor($this->order);
        }

        assertContains($this->order->getProductByName($productName), $this->order->getDeletedProducts());

        if ($this->offer) {
            $this->applied = true;
        }
    }

    /**
     * @Then /^I should not get anything for free$/
     */
    public function iShouldGetNothingForFree() {
        assertEquals(0, count($this->order->getDeletedProducts()));
    }

    /**
     * @Then /^the order total should be "([^"]*)"$/
     */
    public function theOrderTotalShouldBe($resultantPrice) {
        if (!$this->applied && $this->offer) {
            $this->offer->applyFor($this->order);
        }

        assertEquals($resultantPrice, $this->order->getTotalPrice());

        if ($this->offer) {
            $this->applied = true;
        }
    }

    /**
     * @Then /^I should get a 50% discount on "([^"]*)"$/
     */
    public function iShouldGetADiscountOn($productName) {
        if (!$this->applied && $this->offer) {
            $this->offer->applyFor($this->order);
        }

        assertContains($this->order->getProductByName($productName), $this->order->getDeletedProducts());

        if ($this->offer) {
            $this->applied = true;
        }
    }
}
