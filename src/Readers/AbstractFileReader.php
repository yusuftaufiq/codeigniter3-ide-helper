<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory;
use Symfony\Component\Finder\Finder;

/**
 * Undocumented class
 */
abstract class AbstractFileReader
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected string $dir = '/./';

    /**
     * Undocumented variable
     *
     * @var string $path
     */
    protected string $path = '/./application/';

    /**
     * Undocumented variable
     *
     * @var \Symfony\Component\Finder\Finder
     */
    protected Finder $finder;

    /**
     * Undocumented function
     *
     * @param \Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory $finder
     */
    public function __construct(FileFinderFactory $finder)
    {
        $this->finder = $finder->create();
    }

    /**
     * Undocumented function
     *
     * @param string $dir
     * @return self
     */
    public function setDirectory(string $dir): self
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getFullPath(): string
    {
        return getcwd() . $this->dir . $this->path;
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    abstract public function getFiles(): array;
}
