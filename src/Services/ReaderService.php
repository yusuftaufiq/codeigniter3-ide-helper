<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileReaderFactory;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Undocumented class
 */
class ReaderService
{
    protected FileReader $autoloadReader;

    protected FileReader $coreReader;

    protected FileReader $controllerReader;

    protected FileReader $modelReader;

    public function __construct(FileReaderFactory $fileReader)
    {
        $this->autoloadReader = $fileReader->create(FileType::autoload());
        $this->coreReader = $fileReader->create(FileType::core());
        $this->controllerReader = $fileReader->create(FileType::controller());
        $this->modelReader = $fileReader->create(FileType::model());
    }

    /**
     * Undocumented function
     *
     * @param string $dir
     * @return self
     */
    public function setDirectory(string $dir): self
    {
        $this->autoloadReader->setDirectory($dir);
        $this->coreReader->setDirectory($dir);
        $this->controllerReader->setDirectory($dir);
        $this->modelReader->setDirectory($dir);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return \Symfony\Component\Finder\SplFileInfo|null
     */
    public function getAutoloadFile(): ?SplFileInfo
    {
        return $this->autoloadReader->getFirstFile();
    }

    /**
     * Undocumented function
     *
     * @param array $patterns
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getCoreFiles(array $patterns): array
    {
        return $this->coreReader
            ->setPatterns($patterns)
            ->getFiles();
    }

    /**
     * Undocumented function
     *
     * @param array $patterns
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getControllerFiles(array $patterns): array
    {
        return $this->controllerReader
            ->setPatterns($patterns)
            ->getFiles();
    }

    /**
     * Undocumented function
     *
     * @param array $patterns
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getModelFiles(array $patterns): array
    {
        return $this->modelReader
            ->setPatterns($patterns)
            ->getFiles();
    }
}
