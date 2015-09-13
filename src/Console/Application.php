<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 21:45.
 */
namespace AmaxLab\PhpSpeller\Console;

use AmaxLab\PhpSpeller\Console\Command\CheckCommand;
use AmaxLab\PhpSpeller\Console\Command\InfoCommand;
use AmaxLab\PhpSpeller\PhpSpeller;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class Application extends \Symfony\Component\Console\Application
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        error_reporting(-1);
        parent::__construct('PHP Speller', PhpSpeller::VERSION);
        $this->add(new CheckCommand());
        $this->add(new InfoCommand());
    }

    /**
     * @return string
     */
    public function getLongVersion()
    {
        $version = parent::getLongVersion().' by <comment>Igor Bodnar</comment>';
        $commit = '@git-commit@';
        if ('@'.'git-commit@' !== $commit) {
            $version .= ' ('.substr($commit, 0, 7).')';
        }

        return $version;
    }
}
