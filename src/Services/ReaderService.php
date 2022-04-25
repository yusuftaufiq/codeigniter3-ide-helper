<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Enums\ClassTypeEnum;
use Haemanthus\CodeIgniter3IdeHelper\Factories\ClassFileReaderFactory;
use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ClassFileReader;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Undocumented class
 */
class ReaderService
{
    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadReader
     */
    protected AutoloadReader $autoloadReader;

    protected ClassFileReader $coreReader;

    protected ClassFileReader $controllerReader;

    protected ClassFileReader $modelReader;

    public function __construct(
        AutoloadReader $autoloadReader,
        ClassFileReaderFactory $classFileReader
    ) {
        $this->autoloadReader = $autoloadReader;
        $this->coreReader = $classFileReader->create(ClassTypeEnum::core());
        $this->controllerReader = $classFileReader->create(ClassTypeEnum::controller());
        $this->modelReader = $classFileReader->create(ClassTypeEnum::model());
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
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    public function getAutoloadFile(): SplFileInfo
    {
        return $this->autoloadReader->getFiles()[0];
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
