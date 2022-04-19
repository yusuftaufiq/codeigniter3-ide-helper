<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadLibraryNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadModelNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\ClassNodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\MethodCallNodeVisitor;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected ClassNodeVisitor $classVisitor;

    protected MethodCallNodeVisitor $methodCallVisitor;

    protected LoadLibraryNodeCast $libraryCast;

    protected LoadModelNodeCast $modelCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        ClassNodeVisitor $classVisitor,
        MethodCallNodeVisitor $methodCallVisitor,
        LoadLibraryNodeCast $libraryCast,
        LoadModelNodeCast $modelCast
    ) {
        parent::__construct($parser, $traverser);
        $this->classVisitor = $classVisitor;
        $this->methodCallVisitor = $methodCallVisitor;
        $this->libraryCast = $libraryCast;
        $this->modelCast = $modelCast;

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

        $models = array_reduce(
            $this->methodCallVisitor->getFoundLoadModelNodes(),
            fn (array $carry, MethodCall $library): array => array_merge(
                $carry,
                $this->modelCast->cast($library),
            ),
            [],
        );

        return array_merge($libraries, $models);
    }
}
