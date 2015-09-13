<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 12.09.15
 * Time: 14:42.
 */
namespace AmaxLab\PhpSpeller;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
interface ParserInterface
{
    /**
     * @param string $path
     *
     * @return array|Word[]
     */
    public function parseFile($path);

    /**
     * @param \SplFileInfo $fileInfo
     *
     * @return bool
     */
    public function supports(\SplFileInfo $fileInfo);
}
