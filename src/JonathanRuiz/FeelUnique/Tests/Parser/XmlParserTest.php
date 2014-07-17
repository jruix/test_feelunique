<?php

namespace JonathanRuiz\FeelUnique\Tests\Parser;

use JonathanRuiz\FeelUnique\Parser\XmlParser;
use Sabre\XML\Reader;

class XmlParserTest extends \PHPUnit_Framework_TestCase {
    public function testParse_throwsExceptionWithNonExistentFile() {
        $reader = \Mockery::mock('Sabre\XML\Reader');
        $parser = new XmlParser($reader, 'FAKEPATH');

        $this->setExpectedException('JonathanRuiz\FeelUnique\Parser\Exception\FileNotFoundException');
        $parser->parse();
    }

    public function testParse_throwsExceptionWithIncorrectFileFormat() {
        $parser = new XmlParser(new Reader(), __DIR__ . '/fixture/error.xml');

        $this->setExpectedException('JonathanRuiz\FeelUnique\Parser\Exception\ParsingException');
        $parser->parse();
    }

    public function testParseWorks() {
        $parser = new XmlParser(new Reader(), __DIR__ . '/fixture/correct.xml');
        $order = $parser->parse();

        $this->assertInstanceOf('JonathanRuiz\FeelUnique\Model\Order', $order);
        $this->assertEquals(20, $order->getTotalPrice());
        $this->assertEquals(2, count($order->getProducts()));
        $this->assertEquals(1, count($order->getDistinctCategories()));
        $this->assertEquals('C1', $order->getDistinctCategories()[0]->getName());
        $this->assertEquals(2, count($order->getDistinctCategories()[0]->getProducts()));

        $this->assertEquals('P1', $order->getProducts()[0]->getName());
        $this->assertEquals('P2', $order->getProducts()[1]->getName());
    }
}
