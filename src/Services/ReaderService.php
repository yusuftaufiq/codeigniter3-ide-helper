<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ControllerReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\CoreReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ModelReader;
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

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Readers\CoreReader
     */
    protected CoreReader $coreReader;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Readers\ControllerReader
     */
    protected ControllerReader $controllerReader;

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Readers\ModelReader
     */
    protected ModelReader $modelReader;

    /**
     * Undocumented function
     *
     * @param \Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadReader $autoloadReader
     * @param \Haemanthus\CodeIgniter3IdeHelper\Readers\CoreReader $coreReader
     * @param \Haemanthus\CodeIgniter3IdeHelper\Readers\ControllerReader $controllerReader
     * @param \Haemanthus\CodeIgniter3IdeHelper\Readers\ModelReader $modelReader
     */
    public function __construct(
        AutoloadReader $autoloadReader,
        CoreReader $coreReader,
        ControllerReader $controllerReader,
        ModelReader $modelReader
    ) {
        $this->autoloadReader = $autoloadReader;
        $this->coreReader = $coreReader;
        $this->controllerReader = $controllerReader;
        $this->modelReader = $modelReader;
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
