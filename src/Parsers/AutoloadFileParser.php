<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Visitors\AssignArrayNodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class AutoloadFileParser extends AbstractFileParser
{
    protected AssignArrayNodeVisitor $assignArrayNodeVisitor;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser
    ) {
        parent::__construct($parser, $traverser);

        $this->assignArrayNodeVisitor = new AssignArrayNodeVisitor();
        $this->traverser->addVisitor($this->assignArrayNodeVisitor);
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        dump($this->assignArrayNodeVisitor->getFoundAutoloadLibraryNodes());
        dd($this->assignArrayNodeVisitor->getFoundAutoloadModelNodes());
    }
}
