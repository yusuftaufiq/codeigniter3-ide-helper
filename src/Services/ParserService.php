<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Services;

use Haemanthus\CodeIgniter3IdeHelper\Parsers\CoreFileParser;

class ParserService
{
    public CoreFileParser $coreParser;

    public function __construct(CoreFileParser $coreParser)
    {
        $this->coreParser = $coreParser;
    }

    public function parseCore(string $content)
    {
        return $this->coreParser->parse($content);
    }
}
