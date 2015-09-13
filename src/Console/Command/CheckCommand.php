<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 21:51.
 */
namespace AmaxLab\PhpSpeller\Console\Command;

use AmaxLab\PhpSpeller\Parser\HtmlParser;
use AmaxLab\PhpSpeller\Parser\PhpParser;
use AmaxLab\PhpSpeller\Parser\TextParser;
use AmaxLab\PhpSpeller\Parser\TwigParser;
use AmaxLab\PhpSpeller\ParserManager;
use AmaxLab\PhpSpeller\PhpSpeller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class CheckCommand extends Command
{
    /**
     * PhpSpeller instance.
     *
     * @var PhpSpeller
     */
    private $speller;

    /**
     * Construct.
     */
    public function __construct()
    {
        parent::__construct();
        $this->speller = new PhpSpeller();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('check')
            ->addArgument('path', InputArgument::REQUIRED)
            ->addOption('locale', 'l', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, '', array('en'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locales = $input->getOption('locale');
        $path = $input->getArgument('path');
        $output->writeln('');
        $output->writeln(sprintf('Check at <info>%s</info> directory', $path));
        $parser = new ParserManager();
        // TODO register parsers depends on config in command
        $parser->registerParser(new TextParser());
        $parser->registerParser(new HtmlParser());
        $parser->registerParser(new PhpParser());
        $parser->registerParser(new TwigParser());
        $parser->parse($path);

        $result = $this->speller->check($parser->getWords(), $locales);

        $output->writeln(sprintf('Checked %s words', $result->getCountOfWords()));

        if (count($result->getMisspelledWords()) > 0) {
            $output->writeln(sprintf('Spell checking failed with %s errors', count($result->getMisspelledWords())));
            $output->writeln('');

            foreach ($result->getMisspelledWords() as $word) {
                $output->writeln(sprintf('Line #%s, file %s', $word->getLineNumber(), $word->getFile()));
                $output->writeln(str_replace($word->getWord(), '<error>'.$word->getWord().'</error>', $word->getLine()));
                $output->writeln('');
            }

            return 1;
        }

        $output->writeln('<info>No error found</info>');

        return 0;
    }
}
