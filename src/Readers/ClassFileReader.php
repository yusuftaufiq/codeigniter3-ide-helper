<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

/**
 * Undocumented class
 */
class ClassFileReader extends FileReader
{
    public function getFiles(): array
    {
        array_walk($this->patterns, function (string $pattern) {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->in($this->getFullDirectory())
            ->name('*.php');

        return iterator_to_array($this->finder, false);
    }
}
