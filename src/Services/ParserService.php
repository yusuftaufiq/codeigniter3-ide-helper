<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Factories\CoreFileParserFactory;
use Haemanthus\CodeIgniter3IdeHelper\Parsers\AutoloadFileParser;
use Symfony\Component\Finder\SplFileInfo;

class ParserService
{
    public AutoloadFileParser $autoloadParser;

    public CoreFileParserFactory $coreParser;

    public function __construct(
        AutoloadFileParser $autoloadParser,
        CoreFileParserFactory $coreParser
    ) {
        $this->autoloadParser = $autoloadParser;
        $this->coreParser = $coreParser;
    }

    public function parseAutoloadFile(SplFileInfo $file): array
    {
        return $this->autoloadParser->parse($file->getContents());
    }

    public function parseCoreFiles(array $files): array
    {
        return array_map(fn (SplFileInfo $file) => (
            $this->coreParser->create()->parse($file->getContents())
        ), $files);
    }
}
