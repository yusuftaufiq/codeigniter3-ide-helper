<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use PhpParser\ParserFactory;

abstract class AbstractFileParser
{
    protected Parser $parser;

    protected NodeTraverser $traverser;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser
    ) {
        $this->parser = $parser->create(ParserFactory::PREFER_PHP7);
        $this->traverser = $traverser;
    }

    abstract public function parse(string $contents);
}
