<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadLibraryNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadModelNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Objects\ClassDto;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\ClassNodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\MethodCallNodeVisitor;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class CoreFileParser extends AbstractFileParser
{
    protected ClassNodeVisitor $classNodeVisitor;

    protected MethodCallNodeVisitor $methodCallNodeVisitor;

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

        $this->classNodeVisitor = new ClassNodeVisitor();
        $this->methodCallNodeVisitor = new MethodCallNodeVisitor();

        $this->traverser->addVisitor($this->classNodeVisitor);
        $this->traverser->addVisitor($this->methodCallNodeVisitor);
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $loadLibraryNodes = $this->methodCallNodeVisitor->getFoundLoadLibraryNodes();
        $loadLibraryTags = array_reduce($loadLibraryNodes, fn (array $carry, MethodCall $node): array => (
            array_merge($carry, $this->loadLibraryNodeCast->cast($node))
        ), []);

        $loadModelNodes = $this->methodCallNodeVisitor->getFoundLoadModelNodes();
        $loadModelTags = array_reduce($loadModelNodes, fn (array $carry, MethodCall $node): array => (
            array_merge($carry, $this->loadModelNodeCast->cast($node))
        ), []);

        return [new ClassDto(
            $this->classNodeVisitor->getFoundClassNode(),
            array_merge($loadLibraryTags, $loadModelTags)
        )];
    }
}
