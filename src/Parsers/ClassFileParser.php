<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeCasterFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeTraverserFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeVisitorFactory;
use PhpParser\Node;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
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

    /**
     * Undocumented function
     *
     * @return array<ClassStructuralElement>
     */
    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $loadLibraryNodes = $this->methodCallLoadLibraryNodeVisitor->getFoundNodes();
        $loadModelNodes = $this->methodCallLoadModelNodeVisitor->getFoundNodes();

        return array_reduce($this->classNodeVisitor->getFoundNodes(), function (
            array $carry,
            Node $node
        ) use (
            $loadLibraryNodes,
            $loadModelNodes
        ): array {
            if ($node instanceof Node\Stmt\Class_ === false) {
                return $carry;
            }

            $loadLibraryStructuralElements = $this->parseLoadLibraryNodes(
                $this->filterNodesWithSameClass($loadLibraryNodes, $node)
            );
            $loadModelStructuralElements = $this->parseLoadModelNodes(
                $this->filterNodesWithSameClass($loadModelNodes, $node)
            );
            $structuralElements = array_merge($loadLibraryStructuralElements, $loadModelStructuralElements);

            return array_merge($carry, [new ClassStructuralElement($node, $structuralElements)]);
        }, []);
    }

    protected function setNodeVisitor(NodeVisitorFactory $nodeVisitor): self
    {
        $this->traverser->addVisitor(new ParentConnectingVisitor());

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

    /**
     * Undocumented function
     *
     * @param array<Node> $nodes
     *
     * @return array<PropertyStructuralElement>
     */
    protected function parseLoadLibraryNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node $node): array => (
            array_merge($carry, $this->loadLibraryNodeCaster->cast($node))
        ), []);
    }

    /**
     * Undocumented function
     *
     * @param array<Node> $nodes
     *
     * @return array<PropertyStructuralElement>
     */
    protected function parseLoadModelNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node $node): array => (
            array_merge($carry, $this->loadModelNodeCaster->cast($node))
        ), []);
    }

    protected function getClassName(Node $node): ?string
    {
        /** @var Node|null $parent */
        $parent = $node->getAttribute('parent');

        if ($parent instanceof Node\Stmt\Class_) {
            return $parent->name->toString();
        }

        if ($parent !== null) {
            return $this->getClassName($parent);
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @param array<Node> $nodes
     *
     * @return array<Node>
     */
    protected function filterNodesWithSameClass(array $nodes, Node\Stmt\Class_ $classNode): array
    {
        return array_filter($nodes, fn (Node $node): bool => (
            $this->getClassName($node) === $classNode->name->toString()
        ));
    }
}
