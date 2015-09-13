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
class TwigParser implements ParserInterface
{
    /**
     * @param string $path
     *
     * @return array|Word[]
     */
    public function parseFile($path)
    {
        $words = array();
        $twig = new \Twig_Environment(); // TODO should it be configured dynamically?

        $lines = file($path);
        if (count($lines) <= 0) {
            // TODO handle and log error

            return array();
        }

        $tokenStream = $twig->tokenize(implode('', $lines));

        while (!$tokenStream->isEOF()) {
            $token = $tokenStream->next();
            if ($token->getType() === \Twig_Token::TEXT_TYPE) {
                $lineNumber = $token->getLine();
                //split line by line
                foreach (preg_split("/((\r?\n)|(\r\n?))/", $token->getValue()) as $line) {
                    $parts = array();
                    preg_match_all('/(([[:alpha:]]+[\'-])*[[:alpha:]]+\'?)/u', strip_tags($line), $parts, PREG_SET_ORDER);

                    foreach ($parts as $part) {
                        $words[] = new Word(trim($part[0]), $path, $lines[$lineNumber - 1], $lineNumber);
                    }

                    ++$lineNumber;
                }
            }
        }

        return $words;
    }

    /**
     * @param \SplFileInfo $fileInfo
     *
     * @return bool
     */
    public function supports(\SplFileInfo $fileInfo)
    {
        return in_array($fileInfo->getExtension(), array('twig'));
    }
}
