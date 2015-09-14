<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 21:51.
 */
namespace AmaxLab\PhpSpeller\Console\Command;

use AmaxLab\PhpSpeller\PhpSpeller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class InfoCommand extends Command
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
            ->setName('info')
            ->setDescription('Information about available backends and dictionaries.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $info = $this->speller->getInfo();

        $output->writeln('Available Enchant backends:');
        $table = new Table($output);
        $table->setHeaders(array('Provider', 'Description'));
        foreach ($info['providers'] as $backend) {
            $table->addRow(array($backend['name'], $backend['desc']));
        }

        $table->render();

        $output->writeln('Available Enchant dictionaries:');
        $table = new Table($output);
        $table->setHeaders(array('Lang', 'Provider', 'Description'));
        foreach ($info['dictionaries'] as $dictionary) {
            $table->addRow(array($dictionary['lang_tag'], $dictionary['provider_name'], $dictionary['provider_desc']));
        }

        $table->render();
    }
}
