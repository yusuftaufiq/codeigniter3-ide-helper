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

    protected LoadLibraryNodeCast $loadLibraryNodeCast;

    protected LoadModelNodeCast $loadModelNodeCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        LoadLibraryNodeCast $loadLibraryNodeCast,
        LoadModelNodeCast $loadModelNodeCast
    ) {
        parent::__construct($parser, $traverser);
        $this->loadLibraryNodeCast = $loadLibraryNodeCast;
        $this->loadModelNodeCast = $loadModelNodeCast;

        $this->classVisitor = new ClassNodeVisitor();
        $this->methodCallVisitor = new MethodCallNodeVisitor();

        $this->traverser->addVisitor($this->classVisitor);
        $this->traverser->addVisitor($this->methodCallVisitor);
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $loadLibraryNodes = $this->methodCallVisitor->getFoundLoadLibraryNodes();
        $loadLibraryTags = array_reduce($loadLibraryNodes, fn (array $carry, MethodCall $node): array => (
            array_merge($carry, $this->loadLibraryNodeCast->cast($node))
        ), []);

        $loadModelNodes = $this->methodCallVisitor->getFoundLoadModelNodes();
        $loadModelTags = array_reduce($loadModelNodes, fn (array $carry, MethodCall $node): array => (
            array_merge($carry, $this->loadModelNodeCast->cast($node))
        ), []);

        return array_merge($loadLibraryTags, $loadModelTags);
    }
}
