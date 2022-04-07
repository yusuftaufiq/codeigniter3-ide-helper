<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Symfony\Component\Finder\Finder;

abstract class AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $dir = '/./';

    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected $path = '/./application/';

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

    protected function getFullPath()
    {
        return getcwd() . $this->dir . $this->path;
    }

    abstract public function getFiles();
}
