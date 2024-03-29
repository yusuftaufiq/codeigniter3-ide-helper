<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casters\LibraryNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeCasterFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeTraverserFactory;
use Haemanthus\CodeIgniter3IdeHelper\Factories\NodeVisitorFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\ParserFactory;

class AutoloadFileParser extends FileParser
{
    /**
     * Undocumented variable
     *
     * @var array<string>
     */
    protected array $defaultAutoloadLibraries = [
        'benchmark',
        'cache',
        'config',
        'db',
        'input',
        'lang',
        'load',
        'output',
        'security',
        'uri',
    ];

    protected NodeVisitor $autoloadLibraryNodeVisitor;

    protected NodeVisitor $autoloadModelNodeVisitor;

    protected NodeCaster $assignAutoloadLibraryNodeCaster;

    protected NodeCaster $assignAutoloadModelNodeCaster;

    protected BuilderFactory $nodeBuilder;

    public function __construct(
        ParserFactory $parser,
        NodeTraverserFactory $traverser,
        NodeVisitorFactory $nodeVisitor,
        NodeCasterFactory $nodeCaster,
        BuilderFactory $nodeBuilder
    ) {
        parent::__construct($parser, $traverser);

        $this->setNodeVisitor($nodeVisitor);
        $this->setNodeCaster($nodeCaster);

        $this->nodeBuilder = $nodeBuilder;
    }

    /**
     * Undocumented function
     *
     * @return array<ClassStructuralElement>
     */
    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $loadLibraryStructuralElements = $this->parseAutoloadLibraryNodes(
            $this->autoloadLibraryNodeVisitor->getFoundNodes()
        );

        $loadModelStructuralElements = $this->parseAutoloadModelNodes(
            $this->autoloadModelNodeVisitor->getFoundNodes()
        );

        $propertyStructuralElements = array_merge(
            $loadLibraryStructuralElements,
            $loadModelStructuralElements,
            $this->getDefaultAutoloadLibraries(),
        );

        $controllerClassStructuralElement = new ClassStructuralElement(
            $this->nodeBuilder->class('CI_Controller')->getNode(),
            $propertyStructuralElements,
        );

        $modelClassStructuralElement = new ClassStructuralElement(
            $this->nodeBuilder->class('CI_Model')->getNode(),
            $propertyStructuralElements,
        );

        return [$controllerClassStructuralElement, $modelClassStructuralElement];
    }

    protected function setNodeVisitor(NodeVisitorFactory $nodeVisitor): self
    {
        $this->autoloadLibraryNodeVisitor = $nodeVisitor->create(NodeVisitorType::assignAutoloadLibrary());
        $this->traverser->addVisitor($this->autoloadLibraryNodeVisitor);

        $this->autoloadModelNodeVisitor = $nodeVisitor->create(NodeVisitorType::assignAutoloadModel());
        $this->traverser->addVisitor($this->autoloadModelNodeVisitor);

        return $this;
    }

    protected function setNodeCaster(NodeCasterFactory $nodeCaster): self
    {
        $this->assignAutoloadLibraryNodeCaster = $nodeCaster->create(NodeVisitorType::assignAutoloadLibrary());
        $this->assignAutoloadModelNodeCaster = $nodeCaster->create(NodeVisitorType::assignAutoloadModel());

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array<Node> $nodes
     *
     * @return array<PropertyStructuralElement>
     */
    protected function parseAutoloadLibraryNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node $node): array => (
            array_merge($carry, $this->assignAutoloadLibraryNodeCaster->cast($node))
        ), []);
    }

    /**
     * Undocumented function
     *
     * @param array<Node> $nodes
     *
     * @return array<PropertyStructuralElement>
     */
    protected function parseAutoloadModelNodes(array $nodes): array
    {
        return array_reduce($nodes, fn (array $carry, Node $node): array => (
            array_merge($carry, $this->assignAutoloadModelNodeCaster->cast($node))
        ), []);
    }

    /**
     * Undocumented function
     *
     * @return array<PropertyStructuralElement>
     */
    protected function getDefaultAutoloadLibraries(): array
    {
        $mapper = new LibraryNameMapper();

        return array_map(static fn (string $library): PropertyStructuralElement => (
            new PropertyStructuralElement($library, $mapper->concreteClassOf($library))
        ), $this->defaultAutoloadLibraries);
    }
}
