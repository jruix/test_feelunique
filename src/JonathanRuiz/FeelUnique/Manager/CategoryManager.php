<?php

namespace JonathanRuiz\FeelUnique\Manager;

use JonathanRuiz\FeelUnique\Model\Category;

/**
 * We use this class to make sure the categories are not repeated
 * so we always get the already in-memory element (or we create a new one)
 */
class CategoryManager {
    /**
     * @var Category[]
     */
    private $addedCategories = [];

    /**
     * Creates (or simply gets) a category, to avoid duplicates
     * @param $categoryNameToInsert
     * @return Category
     */
    public function create($categoryNameToInsert) {
        foreach ($this->addedCategories as $category) {
            if ($category->getName() === $categoryNameToInsert) {
                return $category;
            }
        }

        $category = new Category($categoryNameToInsert);
        $this->addedCategories[] = $category;

        return $category;
    }
}
