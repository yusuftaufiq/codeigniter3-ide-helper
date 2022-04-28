<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileReader;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileReaderType;
use Haemanthus\CodeIgniter3IdeHelper\Readers\AutoloadFileReader;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ClassFileReader;

final class FileReaderFactory
{
    private FileFinderFactory $finder;

    public function __construct(FileFinderFactory $finder)
    {
        $this->finder = $finder;
    }

    public function create(FileReaderType $type): FileReader
    {
        switch (true) {
            case $type->equals(FileReaderType::autoload()):
                return new AutoloadFileReader($this->finder);

            case $type->equals(FileReaderType::core()):
                return (new ClassFileReader($this->finder))->setPath('./application/core/');

            case $type->equals(FileReaderType::controller()):
                return (new ClassFileReader($this->finder))->setPath('./application/controllers/');

            case $type->equals(FileReaderType::model()):
                return (new ClassFileReader($this->finder))->setPath('./application/models/');

            default:
                throw new \InvalidArgumentException('Unknown FileReaderType');
        }
    }
}
