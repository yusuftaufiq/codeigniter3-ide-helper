<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Enums\ClassTypeEnum;
use Haemanthus\CodeIgniter3IdeHelper\Readers\ClassFileReader;

class ClassFileReaderFactory
{
    protected FileFinderFactory $finder;

    public function __construct(FileFinderFactory $finder)
    {
        $this->finder = $finder;
    }

    public function create(ClassTypeEnum $type): ClassFileReader
    {
        return (new ClassFileReader($this->finder))->setPath($type->directory());
    }
}
