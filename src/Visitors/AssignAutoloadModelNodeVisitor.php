<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;

class AssignAutoloadModelNodeVisitor extends NodeVisitor
{
    use AssignAutoloadChecker {
        isAssignAutoloadArray as protected;
    }

    protected function isAssignArrayAutoloadModel(Node $node): bool
    {
        return $this->isAssignAutoloadArray($node) && $node->var->dim->value === 'models';
    }

    public function enterNode(Node $node)
    {
        if ($this->isAssignArrayAutoloadModel($node)) {
            $this->nodes[] = $node;

            return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }

        return parent::enterNode($node);
    }
}
