<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Factories\CoreFileParserFactory;
use Symfony\Component\Finder\SplFileInfo;

class ParserService
{
    public CoreFileParserFactory $coreParser;

    public function __construct(CoreFileParserFactory $coreParser)
    {
        $this->coreParser = $coreParser;
    }

    public function parseCoreFiles(array $files)
    {
        return array_map(fn (SplFileInfo $file) => (
            $this->coreParser->create()->parse($file->getContents())
        ), $files);
    }
}
