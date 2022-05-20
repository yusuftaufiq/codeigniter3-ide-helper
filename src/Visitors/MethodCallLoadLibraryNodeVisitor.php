<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;

class MethodCallLoadLibraryNodeVisitor extends NodeVisitor
{
    use MethodCallChecker {
        isMethodCallThisLoad as protected;
    }

    protected function isMethodCallThisLoadLibrary(Node $node): bool
    {
        return $this->isMethodCallThisLoad($node) && $node->name->toString() === 'library';
    }

    public function enterNode(Node $node)
    {
        if ($this->isMethodCallThisLoadLibrary($node)) {
            $this->nodes[] = $node;

            return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }

        return parent::enterNode($node);
    }
}
