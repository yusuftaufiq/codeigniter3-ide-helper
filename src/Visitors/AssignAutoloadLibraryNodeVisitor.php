<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;

class AssignAutoloadLibraryNodeVisitor extends NodeVisitor
{
    /**
     * Undocumented function
     *
     * @return int|Node|null
     */
    public function enterNode(Node $node)
    {
        if ($this->isAssignArrayAutoloadLibrary($node)) {
            $this->nodes[] = $node;

            return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }

        return parent::enterNode($node);
    }

    protected function isAssignArrayAutoloadLibrary(Node $node): bool
    {
        return $this->isAssignAutoloadArray($node) && $node->var->dim->value === 'libraries';
    }
}
