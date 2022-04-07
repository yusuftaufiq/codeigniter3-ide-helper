<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

class ControllerReader extends AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $pattern = [];

    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected $path = './application/controllers/';

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getFiles()
    {
        array_walk($this->pattern, function ($pattern) {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->in($this->getFullPath())
            ->name('*.php');

        return iterator_to_array($this->finder, false);
    }
}
