<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Readers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader as FileReaderContract;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileFinderFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Undocumented class
 */
abstract class FileReader implements FileReaderContract
{
    protected ?string $dir = null;

    protected array $patterns = [];

    protected ?string $path = null;

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

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
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
