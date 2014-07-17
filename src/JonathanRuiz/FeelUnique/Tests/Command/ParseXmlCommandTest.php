<?php

namespace JonathanRuiz\FeelUnique\Tests\Command;

use JonathanRuiz\FeelUnique\Command\ParseXmlCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;


class ParseXmlCommandTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @var Command
     */
    private $command;

    public function setUp() {
        $application = new Application();
        $application->add(new ParseXmlCommand());

        $this->command = $application->find('jonathanruiz:feelunique:apply-discount');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testCommandWithNonExistentFile() {
        $this->commandTester->execute(
            [
                'command' => $this->command->getName(),
                'path' => 'FAKE'
            ]
        );

        $this->assertRegExp('/File not found!/', $this->commandTester->getDisplay());
    }

    public function testCommandWithIncorrectXmlFile() {
        $this->commandTester->execute(
            [
                'command' => $this->command->getName(),
                'path' => __DIR__ . '/fixture/error.xml'
            ]
        );

        $this->assertRegExp('/Error parsing file!/', $this->commandTester->getDisplay());
    }

    public function testCommandWithFile() {
        $this->commandTester->execute(
            [
                'command' => $this->command->getName(),
                'path' => __DIR__ . '/fixture/correct.xml'
            ]
        );

        $this->assertContains('P1 (5) in category C1', $this->commandTester->getDisplay());
        $this->assertContains('P2 (9) in category C2', $this->commandTester->getDisplay());
        $this->assertContains('P3 (5) in category C2', $this->commandTester->getDisplay());
        $this->assertContains('P4 (6) in category C2', $this->commandTester->getDisplay());
        $this->assertContains('P5 (8) in category C1', $this->commandTester->getDisplay());
        $this->assertContains('P6 (6) in category C3', $this->commandTester->getDisplay());
        $this->assertContains('P7 (15) in category C3', $this->commandTester->getDisplay());

        $this->assertContains('Found 7 products in order', $this->commandTester->getDisplay());
    }
}
