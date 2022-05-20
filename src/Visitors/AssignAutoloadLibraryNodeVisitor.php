<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;

class AssignAutoloadLibraryNodeVisitor extends NodeVisitor
{
    use AssignAutoloadChecker {
        isAssignAutoloadArray as protected;
    }

    protected function isAssignArrayAutoloadLibrary(Node $node): bool
    {
        return $this->isAssignAutoloadArray($node) && $node->var->dim->value === 'libraries';
    }

    public function enterNode(Node $node)
    {
        if ($this->isAssignArrayAutoloadLibrary($node)) {
            $this->nodes[] = $node;

            return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }

        return parent::enterNode($node);
    }
}
