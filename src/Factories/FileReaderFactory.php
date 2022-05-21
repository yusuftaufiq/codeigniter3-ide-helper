<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadFileReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ClassFileReader;
use Symfony\Component\Filesystem\Filesystem;

class FileReaderFactory
{
    protected const APP_CORE_DIR = './application/core/';

    protected const APP_CONTROLLER_DIR = './application/controllers/';

    protected const APP_MODEL_DIR = './application/models/';

    protected FileFinderFactory $finder;

    protected Filesystem $fs;

    public function __construct(
        FileFinderFactory $finder,
        Filesystem $fs
    ) {
        $this->finder = $finder;
        $this->fs = $fs;
    }

    public function create(FileType $type): FileReader
    {
        switch (true) {
            case $type->equals(FileType::autoload()):
                return new AutoloadFileReader($this->finder, $this->fs);

            case $type->equals(FileType::core()):
                return (new ClassFileReader($this->finder, $this->fs))->setFileDirectory(self::APP_CORE_DIR);

            case $type->equals(FileType::controller()):
                return (new ClassFileReader($this->finder, $this->fs))->setFileDirectory(self::APP_CONTROLLER_DIR);

            case $type->equals(FileType::model()):
                return (new ClassFileReader($this->finder, $this->fs))->setFileDirectory(self::APP_MODEL_DIR);

            default:
                throw new \InvalidArgumentException("Unsupported file type for {$type->value}");
        }
    }
}
