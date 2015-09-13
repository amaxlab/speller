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
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $backends = $this->speller->getBackends();

        $output->writeln('Available Enchant backends:');
        $table = new Table($output);
        $table->setHeaders(array('Provider', 'Description'));
        foreach ($backends as $backend) {
            $table->addRow(array($backend['name'], $backend['desc']));
        }

        $table->render();
    }
}
