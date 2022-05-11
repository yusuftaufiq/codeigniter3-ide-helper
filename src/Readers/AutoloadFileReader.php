<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

class AutoloadFileReader extends FileReader
{
    protected ?string $path = './application/config/';

    public function getFiles(): array
    {
        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('autoload.php');

        return iterator_to_array($this->finder, false);
    }
}
