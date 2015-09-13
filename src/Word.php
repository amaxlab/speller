<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 22:21.
 */
namespace AmaxLab\PhpSpeller;

/**
 * Class represents Word - unit for spell check.
 *
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class Word
{
    /**
     * @var string
     */
    private $word;

    /**
     * @var bool
     */
    private $checked;

    /**
     * @var array
     */
    private $suggests;

    /**
     * File where error was found.
     *
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $line;

    /**
     * @var int
     */
    private $lineNumber;

    /**
     * Word constructor.
     *
     * @param string $word
     * @param string $file
     * @param string $line
     * @param int    $lineNumber
     */
    public function __construct($word, $file, $line, $lineNumber)
    {
        $this->word = $word;
        $this->file = $file;
        $this->lineNumber = $lineNumber;
        $this->line = trim($line); // do not write spaces to output
        $this->checked = false;
        $this->suggests = array();
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param string $word
     *
     * @return Word
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
    }

    /**
     * @param bool $checked
     *
     * @return Word
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * @return array
     */
    public function getSuggests()
    {
        return $this->suggests;
    }

    /**
     * @param array $suggests
     *
     * @return Word
     */
    public function setSuggests($suggests)
    {
        $this->suggests = $suggests;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     *
     * @return Word
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     *
     * @return Word
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $line
     *
     * @return Word
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }
}
