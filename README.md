# Jonathan Ruiz Peinado

You should implement a simple command line utility which will load an order from an XML file and update its total.

New total should be calculated considering the promotional offer, chosen based on an option passed in to the command. The path to an XML file should be passed in as an argument.

## Installation

To run it, make sure you have PHP installed, and type the following commands in your terminal:

```
$ cd /path/to/project
$ composer install
```

Now you should execute the command; here are some execution samples:

```
$ ./console jonathanruiz:feelunique:apply-discount XML_PATH
$ ./console jonathanruiz:feelunique:apply-discount XML_PATH --offer=3x2
$ ./console jonathanruiz:feelunique:apply-discount XML_PATH --offer=50%
$ ./console jonathanruiz:feelunique:apply-discount XML_PATH --offer=3x2 --offer=50%
```

## Technologies used

* Symfony Console Component (to show the command)
* Doctrine ArrayCollection to have a better array handling
* XML parser

## Running tests

```./vendor/bin/phpunit src```
