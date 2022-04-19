<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\NodeLibraryCast;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\ClassNodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\MethodCallNodeVisitor;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected ClassNodeVisitor $classVisitor;

    protected MethodCallNodeVisitor $methodCallVisitor;

    protected NodeLibraryCast $libraryCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        ClassNodeVisitor $classVisitor,
        MethodCallNodeVisitor $methodCallVisitor,
        NodeLibraryCast $libraryCast
    ) {
        parent::__construct($parser, $traverser);
        $this->classVisitor = $classVisitor;
        $this->methodCallVisitor = $methodCallVisitor;
        $this->libraryCast = $libraryCast;

        $this->traverser->addVisitor($this->classVisitor);
        $this->traverser->addVisitor($this->methodCallVisitor);
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $libraries = array_reduce(
            $this->methodCallVisitor->getFoundLoadLibraryNodes(),
            fn (array $carry, MethodCall $library): array => array_merge(
                $carry,
                $this->libraryCast->cast($library),
            ),
            [],
        );

        $models = $this->methodCallVisitor->getFoundLoadModelNodes();

        return array_merge($libraries);
    }
}
