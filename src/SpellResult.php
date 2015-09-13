<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 12.09.15
 * Time: 15:03.
 */
namespace AmaxLab\PhpSpeller;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class SpellResult
{
    /**
     * @var array|Word[]
     */
    private $misspelledWords;

    /**
     * @var int
     */
    private $countOfWords;

    /**
     * SpellResult constructor.
     */
    public function __construct()
    {
        $this->misspelledWords = array();
    }

    /**
     * @return Word[]|array
     */
    public function getMisspelledWords()
    {
        return $this->misspelledWords;
    }

    /**
     * @param Word[]|array $misspelledWords
     *
     * @return SpellResult
     */
    public function setMisspelledWords($misspelledWords)
    {
        $this->misspelledWords = $misspelledWords;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountOfWords()
    {
        return $this->countOfWords;
    }

    /**
     * @param int $countOfWords
     *
     * @return SpellResult
     */
    public function setCountOfWords($countOfWords)
    {
        $this->countOfWords = $countOfWords;

        return $this;
    }
}
