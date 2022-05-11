<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

/**
 * Undocumented class
 */
class ClassFileReader extends FileReader
{
    public function getFiles(): array
    {
        array_walk($this->patterns, function ($pattern) {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('*.php');

        return iterator_to_array($this->finder, false);
    }
}
