<?php

namespace JonathanRuiz\FeelUnique\Tests\Manager;

use JonathanRuiz\FeelUnique\Manager\CategoryManager;

class CategoryManagerTest extends \PHPUnit_Framework_TestCase {
    public function testCategoriesAreNotDuplicated() {
        $manager = new CategoryManager();

        $shampoo1 = $manager->create('Shampoo');
        $shampoo2 = $manager->create('Shampoo');
        $shampoo3 = $manager->create('Shampoo');

        $this->assertTrue($shampoo1 === $shampoo2);
        $this->assertTrue($shampoo2 === $shampoo3);
        $this->assertTrue($shampoo1 === $shampoo3);
    }
}
