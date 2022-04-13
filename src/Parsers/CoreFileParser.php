<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected MethodCallNodeVisitor $visitor;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser
    ) {
        parent::__construct($parser, $traverser);
        $this->visitor = new MethodCallNodeVisitor();
        $this->traverser->addVisitor($this->visitor);
    }

    public function parse(string $contents)
    {
        $this->traverser->traverse($this->parser->parse($contents));

        return array_merge(
            $this->visitor->getFoundLibraryNodes(),
            $this->visitor->getFoundModelNodes(),
        );
    }
}
