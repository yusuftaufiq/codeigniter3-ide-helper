<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeCasterFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeTraverserFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeVisitorFactory;
use PhpParser\Node;
use PhpParser\ParserFactory;

class ClassFileParser extends FileParser
{
    protected NodeVisitor $classNodeVisitor;

    protected NodeVisitor $methodCallLoadLibraryNodeVisitor;

    protected NodeVisitor $methodCallLoadModelNodeVisitor;

    protected NodeCaster $loadLibraryNodeCaster;

    protected NodeCaster $loadModelNodeCaster;

    public function __construct(
        ParserFactory $parser,
        NodeTraverserFactory $traverser,
        NodeVisitorFactory $nodeVisitor,
        NodeCasterFactory $nodeCaster
    ) {
        parent::__construct($parser, $traverser);

        $this->setNodeVisitor($nodeVisitor);
        $this->setNodeCaster($nodeCaster);
    }

    protected function setNodeVisitor(NodeVisitorFactory $nodeVisitor): self
    {
        $this->classNodeVisitor = $nodeVisitor->create(NodeVisitorType::class());
        $this->traverser->addVisitor($this->classNodeVisitor);

        $this->methodCallLoadLibraryNodeVisitor = $nodeVisitor->create(NodeVisitorType::methodCallLoadLibrary());
        $this->traverser->addVisitor($this->methodCallLoadLibraryNodeVisitor);

        $this->methodCallLoadModelNodeVisitor = $nodeVisitor->create(NodeVisitorType::methodCallLoadModel());
        $this->traverser->addVisitor($this->methodCallLoadModelNodeVisitor);

        return $this;
    }

    protected function setNodeCaster(NodeCasterFactory $nodeCaster): self
    {
        $this->loadLibraryNodeCaster = $nodeCaster->create(NodeVisitorType::methodCallLoadLibrary());
        $this->loadModelNodeCaster = $nodeCaster->create(NodeVisitorType::methodCallLoadModel());

        return $this;
    }

    protected function parseLoadLibraryNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node\Expr\MethodCall $node): array => (
            array_merge($carry, $this->loadLibraryNodeCaster->cast($node))
        ), []);
    }

    protected function parseLoadModelNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node\Expr\MethodCall $node): array => (
            array_merge($carry, $this->loadModelNodeCaster->cast($node))
        ), []);
    }

    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $loadLibraryStructuralElements = $this->parseLoadLibraryNodes(
            $this->methodCallLoadLibraryNodeVisitor->getFoundNodes()
        );

        $loadModelStructuralElements = $this->parseLoadModelNodes(
            $this->methodCallLoadModelNodeVisitor->getFoundNodes()
        );

        $classStructuralElement = new ClassStructuralElement(
            $this->classNodeVisitor->getFirstFoundNode(),
            array_merge($loadLibraryStructuralElements, $loadModelStructuralElements),
        );

        return [$classStructuralElement];
    }
}
