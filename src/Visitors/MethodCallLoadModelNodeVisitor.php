<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;

class MethodCallLoadModelNodeVisitor extends NodeVisitor
{
    /**
     * Undocumented function
     *
     * @return int|Node|null
     */
    public function enterNode(Node $node)
    {
        if ($this->isMethodCallThisLoadModel($node)) {
            $this->nodes[] = $node;

            return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }

        return parent::enterNode($node);
    }

    protected function isMethodCallThisLoadModel(Node $node): bool
    {
        return $this->isMethodCallThisLoad($node) && $node->name->toString() === 'model';
    }
}
