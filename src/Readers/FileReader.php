<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader as FileReaderContract;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

abstract class FileReader implements FileReaderContract
{
    protected ?string $rootDirectory = null;

    protected ?string $fileDirectory = null;

    protected array $patterns = [];
    /**
     * Undocumented variable
     *
     * @var \Symfony\Component\Finder\Finder
     */
    protected Finder $finder;

    protected Filesystem $fs;

    /**
     * Undocumented function
     *
     * @param \Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory $finder
     */
    public function __construct(
        FileFinderFactory $finder,
        Filesystem $fs
    ) {
        $this->finder = $finder->create();
        $this->fs = $fs;
    }

    protected function addSuffixDirectoryIfNotExists(string $directory): string
    {
        if (substr(strrev($directory), 0, 1) === '/') {
            return $directory;
        }

        return $directory . '/';
    }

    /**
     * Undocumented function
     *
     * @param string $rootDirectory
     * @return self
     */
    public function setRootDirectory(string $rootDirectory): self
    {
        $this->rootDirectory = $this->addSuffixDirectoryIfNotExists($rootDirectory);

        return $this;
    }

    public function setFileDirectory(string $fileDirectory): self
    {
        $this->fileDirectory = $this->addSuffixDirectoryIfNotExists($fileDirectory);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getFullDirectory(): string
    {
        return getcwd() . '/' . $this->rootDirectory . $this->fileDirectory;
    }

    /**
     * Undocumented function
     *
     * @param array $patterns
     * @return self
     */
    public function setPatterns(array $patterns): self
    {
        $this->patterns = $patterns;

        return $this;
    }

    public function isDirectoryExists(): bool
    {
        return $this->fs->exists($this->getFullDirectory());
    }

    public function getFirstFile(): ?SplFileInfo
    {
        return $this->getFiles()[0] ?? null;
    }
}
