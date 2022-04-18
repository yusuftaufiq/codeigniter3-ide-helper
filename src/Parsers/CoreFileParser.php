<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\NodeLibraryCast;
use Haemanthus\CodeIgniter3IdeHelper\Objects\DocumentBlockDTO;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\MethodCallNodeVisitor;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected MethodCallNodeVisitor $visitor;

    protected NodeLibraryCast $nodeLibraryCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser
    ) {
        parent::__construct($parser, $traverser);
        $this->visitor = new MethodCallNodeVisitor();
        $this->traverser->addVisitor($this->visitor);
        $this->nodeLibraryCast = new NodeLibraryCast();
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $libraries = array_map(
            fn (MethodCall $library): ?DocumentBlockDTO => $this->nodeLibraryCast->cast($library),
            $this->visitor->getFoundLoadLibraryNodes(),
        );

        $models = $this->visitor->getFoundLoadModelNodes();

        return array_merge($libraries, $models);
    }
}
