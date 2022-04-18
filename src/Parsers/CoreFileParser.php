<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\NodeLibraryCast;
use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDTO;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\MethodCallNodeVisitor;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected MethodCallNodeVisitor $visitor;

    protected NodeLibraryCast $libraryCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        MethodCallNodeVisitor $visitor,
        NodeLibraryCast $libraryCast
    ) {
        parent::__construct($parser, $traverser);
        $this->visitor = $visitor;
        $this->traverser->addVisitor($this->visitor);
        $this->libraryCast = $libraryCast;
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $libraries = array_reduce(
            $this->visitor->getFoundLoadLibraryNodes(),
            fn (array $carry, MethodCall $library): array => array_merge(
                $carry,
                $this->libraryCast->cast($library),
            ),
            [],
        );

        $models = $this->visitor->getFoundLoadModelNodes();

        return array_merge($libraries);
    }
}
