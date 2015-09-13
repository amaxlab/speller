<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 12.09.15
 * Time: 14:49.
 */
namespace AmaxLab\PhpSpeller\Parser;

use AmaxLab\PhpSpeller\ParserInterface;
use AmaxLab\PhpSpeller\Word;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class TextParser implements ParserInterface
{
    /**
     * @param string $path
     *
     * @return array|Word[]
     */
    public function parseFile($path)
    {
        $lineNumber = 0;
        $handle = fopen($path, 'r');
        if (!$handle) {
            // TODO handle and log error

            return array();
        }

        $words = array();
        while (($line = fgets($handle)) !== false) {
            ++$lineNumber;
            $parts = array();
            preg_match_all('/(([[:alpha:]]+[\'-])*[[:alpha:]]+\'?)/u', $line, $parts, PREG_SET_ORDER);

            foreach ($parts as $part) {
                $words[] = new Word(trim($part[0]), $path, $line, $lineNumber);
            }
        }
        fclose($handle);

        return $words;
    }

    /**
     * @param \SplFileInfo $fileInfo
     *
     * @return bool
     */
    public function supports(\SplFileInfo $fileInfo)
    {
        return in_array($fileInfo->getExtension(), array('txt', 'md'));
    }
}
