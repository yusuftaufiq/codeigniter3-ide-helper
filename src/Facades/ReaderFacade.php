<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileReaderFactory;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Undocumented class
 */
class ReaderFacade
{
    protected FileReader $autoloadReader;

    protected FileReader $coreReader;

    protected FileReader $controllerReader;

    protected FileReader $modelReader;

    protected ?string $rootDirectory = null;

    public function __construct(FileReaderFactory $fileReader)
    {
        $this->autoloadReader = $fileReader->create(FileType::autoload());
        $this->coreReader = $fileReader->create(FileType::core());
        $this->controllerReader = $fileReader->create(FileType::controller());
        $this->modelReader = $fileReader->create(FileType::model());
    }

    public function setRootDirectory(string $dir): self
    {
        $this->autoloadReader->setRootDirectory($dir);
        $this->coreReader->setRootDirectory($dir);
        $this->controllerReader->setRootDirectory($dir);
        $this->modelReader->setRootDirectory($dir);

        $this->rootDirectory = $dir;

        return $this;
    }

    public function getRootDirectory(): ?string
    {
        return $this->rootDirectory;
    }

    public function setPatterns(array $patterns): self
    {
        $this->coreReader->setPatterns($patterns);
        $this->controllerReader->setPatterns($patterns);
        $this->modelReader->setPatterns($patterns);

        return $this;
    }

    public function isAllDirectoryExists(): bool
    {
        return $this->autoloadReader->isDirectoryExists()
            && $this->coreReader->isDirectoryExists()
            && $this->controllerReader->isDirectoryExists()
            && $this->modelReader->isDirectoryExists();
    }

    public function getAutoloadFile(): ?SplFileInfo
    {
        return $this->autoloadReader->getFirstFile();
    }

    public function getClassFiles(): array
    {
        return array_merge(
            $this->coreReader->getFiles(),
            $this->controllerReader->getFiles(),
            $this->modelReader->getFiles(),
        );
    }
}
