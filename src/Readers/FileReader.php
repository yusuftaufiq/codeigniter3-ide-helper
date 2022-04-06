<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Symfony\Component\Finder\Finder;

class FileReader
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $dir = './';

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
    protected $path = './application/';

    /**
     * Undocumented variable
     *
     * @var \Symfony\Component\Finder\Finder
     */
    protected $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function setDirectory($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getFullPath()
    {
        return getcwd() . $this->dir . $this->path;
    }

    public function getFiles()
    {
        array_walk($this->pattern, function ($pattern) {
            $this->finder->path($pattern);
        });

        $this->finder
            ->files()
            ->name('*.php')
            ->in($this->getFullPath());

        return $this->finder;
    }
}
