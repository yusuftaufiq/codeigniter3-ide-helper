<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader as FileReaderContract;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory;
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
     * @param string $rootDirectory
     * @return self
     */
    public function setRootDirectory(string $rootDirectory): self
    {
        $this->rootDirectory = $rootDirectory;

        return $this;
    }

    public function setFileDirectory(string $fileDirectory): self
    {
        $this->fileDirectory = $fileDirectory;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getFullDirectory(): string
    {
        return getcwd() . $this->rootDirectory . $this->fileDirectory;
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

    public function getFirstFile(): ?SplFileInfo
    {
        return $this->getFiles()[0] ?? null;
    }
}
