<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ControllerReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ModelReader;

class ReaderService
{
    protected $autoloadReader;

    protected $controllerReader;

    protected $modelReader;

    public function __construct(
        AutoloadReader $autoloadReader,
        ControllerReader $controllerReader,
        ModelReader $modelReader
    ) {
        $this->autoloadReader = $autoloadReader;
        $this->controllerReader = $controllerReader;
        $this->modelReader = $modelReader;
    }

    public function setDirectory($dir)
    {
        $this->autoloadReader->setDirectory($dir);
        $this->controllerReader->setDirectory($dir);
        $this->modelReader->setDirectory($dir);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    public function getAutoloadFile()
    {
        return $this->autoloadReader->getFiles()[0];
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getControllerFiles($pattern)
    {
        return $this->controllerReader
            ->setPattern($pattern)
            ->getFiles();
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getModelFiles($pattern)
    {
        return $this->modelReader
            ->setPattern($pattern)
            ->getFiles();
    }
}
