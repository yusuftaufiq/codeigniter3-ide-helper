<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use Haemanthus\CodeIgniter3IdeHelper\Casts\AutoloadLibraryNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Visitors\AssignArrayNodeVisitor;
use PhpParser\Node\Expr\Assign;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class AutoloadFileParser extends AbstractFileParser
{
    protected AssignArrayNodeVisitor $assignArrayNodeVisitor;

    protected AutoloadLibraryNodeCast $autoloadLibraryNodeCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        AutoloadLibraryNodeCast $autoloadLibraryNodeCast
    ) {
        parent::__construct($parser, $traverser);
        $this->autoloadLibraryNodeCast = $autoloadLibraryNodeCast;
        $this->assignArrayNodeVisitor = new AssignArrayNodeVisitor();

        $this->traverser->addVisitor($this->assignArrayNodeVisitor);
    }

    /**
     * TODO:
     * - Create default loaded core class
     * - Create AutoloadLibraryNodeCast
     *   - Check if node is $autoload['libraries'] variable expression
     *   - Create handler if node has alias
     * - Create AutoloadModelNodeCast
     * - Create ClassDto instance
     * - Reduce space & time complexity
     */
    public function parse(string $contents): array
    {
        $this->traverser->traverse($this->parser->parse($contents));

        $autoloadLibraryNodes = $this->assignArrayNodeVisitor->getFoundAutoloadLibraryNodes();
        $autoloadLibraryTags = array_reduce($autoloadLibraryNodes, fn (array $carry, Assign $node): array => (
            array_merge($carry, $this->autoloadLibraryNodeCast->cast($node))
        ), []);

        dd($autoloadLibraryTags);

        dd($this->assignArrayNodeVisitor->getFoundAutoloadModelNodes());
    }
}
