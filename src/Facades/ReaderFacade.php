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

    public function __construct(FileReaderFactory $fileReader)
    {
        $this->autoloadReader = $fileReader->create(FileType::autoload());
        $this->coreReader = $fileReader->create(FileType::core());
        $this->controllerReader = $fileReader->create(FileType::controller());
        $this->modelReader = $fileReader->create(FileType::model());
    }

    public function setDirectory(string $dir): self
    {
        $this->autoloadReader->setDirectory($dir);
        $this->coreReader->setDirectory($dir);
        $this->controllerReader->setDirectory($dir);
        $this->modelReader->setDirectory($dir);

        return $this;
    }

    public function setPatterns(array $patterns): self
    {
        $this->coreReader->setPatterns($patterns);
        $this->controllerReader->setPatterns($patterns);
        $this->modelReader->setPatterns($patterns);

        return $this;
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
