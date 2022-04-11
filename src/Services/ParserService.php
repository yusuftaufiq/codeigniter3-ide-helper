<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

class ParserService
{
    public $autoloadParser;

    public $coreParser;

    public function __construct(
        $autoloadParser,
        $coreParser
    ) {
        $this->autoloadParser = $autoloadParser;
        $this->coreParser = $coreParser;
    }

    public function parseAutoload(string $content)
    {
        $this->autoloadParser->parse($content);
    }

    public function parseCore(string $content)
    {
        $this->coreParser->parse($content);
    }
}
