<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 22:39.
 */
namespace AmaxLab\PhpSpeller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class ParserManager
{
    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var array|Word[]
     */
    private $words;

    /**
     * @var array|ParserInterface[]
     */
    private $parsers;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->fileSystem = new FileSystem();
        $this->finder = new Finder();
        $this->words = array();
        $this->parsers = array();
    }

    /**
     * @param ParserInterface $parser
     *
     * @return $this
     */
    public function registerParser(ParserInterface $parser)
    {
        $this->parsers[] = $parser;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function parse($path)
    {
        if (!$this->fileSystem->isAbsolutePath($path)) {
            $path = getcwd().DIRECTORY_SEPARATOR.$path;
        }

        if (!is_file($path)) {
            $this->finder->files()->in($path)->ignoreDotFiles(true)->ignoreVCS(true)->ignoreUnreadableDirs(true);

            foreach ($this->finder as $file) {
                $this->parseFile($file);
            }

            return $this;
        }
        $this->parseFile($path);

        return $this;
    }

    /**
     * @return Word[]|array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param string $file
     */
    private function parseFile($file)
    {
        $fileInfo = new \SplFileInfo($file);
        foreach ($this->parsers as $parser) {
            if ($parser->supports($fileInfo)) {
                $this->words = array_merge($this->words, $parser->parseFile($file));

                return;
            }
        }
    }
}
