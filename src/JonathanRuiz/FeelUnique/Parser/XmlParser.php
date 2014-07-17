<?php

namespace JonathanRuiz\FeelUnique\Parser;

use JonathanRuiz\FeelUnique\Manager\CategoryManager;
use JonathanRuiz\FeelUnique\Model\Order;
use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Parser\Exception\FileNotFoundException;
use JonathanRuiz\FeelUnique\Parser\Exception\ParsingException;
use Sabre\XML\LibXMLException;
use Sabre\XML\Reader;

/**
 * Parser implementation for XML
 */
class XmlParser implements ParserInterface {
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var string
     */
    private $path;

    /**
     * @param Reader $reader
     * @param $path
     */
    public function __construct(Reader $reader, $path) {
        $this->reader = $reader;
        $this->path = $path;
    }

    /**
     * @throws FileNotFoundException|ParsingException
     * @return Order
     */
    public function parse() {
        if (!file_exists($this->path)) {
            throw new FileNotFoundException;
        }

        try {
            $this->reader->open($this->path);
            $data = $this->reader->parse();

            $categoryManager = new CategoryManager();
            $order = new Order();

            foreach ($data['value'][0]['value'] as $product) {
                $name = $product['attributes']['title'];
                $price = $product['attributes']['price'];
                $categoryName = $product['value'][0]['value'];

                $category = $categoryManager->create($categoryName);
                $order->add(new Product($name, $price, $category));
            }

            return $order;
        } catch (LibXMLException $e) {
            throw new ParsingException;
        }
    }
}
