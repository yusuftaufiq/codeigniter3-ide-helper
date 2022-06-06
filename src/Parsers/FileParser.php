<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileParser as FileParserContract;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeTraverserFactory;
use PhpParser\NodeTraverserInterface;
use PhpParser\Parser;
use PhpParser\ParserFactory;

abstract class FileParser implements FileParserContract
{
    protected Parser $parser;

    protected NodeTraverserInterface $traverser;

    public function __construct(
        ParserFactory $parser,
        NodeTraverserFactory $traverser
    ) {
        $this->parser = $parser->create(ParserFactory::PREFER_PHP7);
        $this->traverser = $traverser->create();
    }
}
