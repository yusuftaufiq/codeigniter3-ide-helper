<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

class AutoloadReader extends AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected $path = './application/config/';

    public function getFiles()
    {
        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('autoload.php');

        return iterator_to_array($this->finder, false);
    }
}
