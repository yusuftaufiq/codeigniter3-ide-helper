<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Readers\FileReader;

class ReaderService
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected static $autoloadPath = './application/config/autoload.php';

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected static $controllerPath = './application/controllers/';

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected static $modelPath = './application/models/';

    /**
     * Undocumented variable
     *
     * @var \Haemanthus\CodeIgniter3IdeHelper\Readers\FileReader
     */
    protected $fileReader;

    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function setDirectory($dir)
    {
        $this->fileReader->setDirectory($dir);

        return $this;
    }

    protected function getFiles($path, $pattern = [])
    {
        $files = $this->fileReader
            ->setPath($path)
            ->setPattern($pattern)
            ->getFiles();

        return iterator_to_array($files, false);
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getAutoloadFile()
    {
        return $this->getFiles(static::$autoloadPath);
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getControllerFiles($pattern)
    {
        return $this->getFiles(static::$controllerPath, $pattern);
    }

    /**
     * Undocumented function
     *
     * @return array<\Symfony\Component\Finder\SplFileInfo>
     */
    public function getModelFiles($pattern)
    {
        return $this->getFiles(static::$modelPath, $pattern);
    }
}
