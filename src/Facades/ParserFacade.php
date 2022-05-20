<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\FileParserFactory;
use Symfony\Component\Finder\SplFileInfo;

class ParserFacade
{
    protected FileParserFactory $fileParser;

    public function __construct(FileParserFactory $fileParser)
    {
        $this->fileParser = $fileParser;
    }

    public function parseAutoloadFile(SplFileInfo $file): array
    {
        return $this->fileParser
            ->create(FileType::autoload())
            ->parse($file->getContents());
    }

    public function parseClassFiles(array $files): array
    {
        return array_reduce($files, function (array $carry, SplFileInfo $file): array {
            $structuralElements = $this->fileParser
                ->create(FileType::core())
                ->parse($file->getContents());

            if (
                array_key_exists(0, $structuralElements) === false
                || count($structuralElements[0]->getProperties()) === 0
            ) {
                return $carry;
            }

            return array_merge($carry, $structuralElements);
        }, []);
    }
}
