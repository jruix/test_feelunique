<?php

namespace JonathanRuiz\FeelUnique\Command;

use JonathanRuiz\FeelUnique\Model\Product;
use JonathanRuiz\FeelUnique\Offer\Exception\InvalidOfferTypeException;
use JonathanRuiz\FeelUnique\Offer\OfferFactory;
use JonathanRuiz\FeelUnique\Parser\Exception\FileNotFoundException;
use JonathanRuiz\FeelUnique\Parser\Exception\ParsingException;
use JonathanRuiz\FeelUnique\Parser\XmlParser;
use Sabre\XML\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Parses an XML file and gets the discount
 * based on an offer (or multiple) specified
 * by the command line
 */
class ParseXmlCommand extends Command {
    /**
     * Command configuration
     */
    protected function configure() {
        $this
            ->setName('jonathanruiz:feelunique:apply-discount')
            ->setDescription('Applies a discount based on an XML file (and a discount rate)')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Where is the XML file?'
            )
            ->addOption(
                'offer',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'If set, applies the specified offer'
            );
    }

    /**
     * Executes the command, applies the discount and shows the result
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        try {
            $parser = new XmlParser(new Reader(), $input->getArgument('path'));
            $order = $parser->parse();

            $output->writeln('Found <info>' . count($order) . '</info> products in order');

            /** @var Product $product */
            foreach ($order as $product) {
                $message = sprintf(
                    '%s (%s) in category <info>%s</info>',
                    $product->getName(),
                    $product->getPrice(),
                    $product->getCategory()->getName()
                );

                $output->writeln($message);
            }

            $output->writeln('<comment>Recalculating price based on offer...</comment>');

            $offers = $input->getOption('offer');
            foreach ($offers as $offer) {
                $offerImplementation = OfferFactory::create($offer);
                $order = $offerImplementation->applyFor($order);
            }

            $output->writeln('The new price after applying discounts is: <info>' . $order->getTotalPrice() . '</info>');

        } catch (FileNotFoundException $e) {
            $output->writeln('<error>File not found!</error>');
        } catch (ParsingException $e) {
            $output->writeln('<error>Error parsing file!</error>');
        } catch (InvalidOfferTypeException $e) {
            $output->writeln('<error>The specified offer type is invalid</error>');
        } catch (\Exception $e) {
            $output->writeln('<error>Unexpected exception</error>');
        }
    }
}
