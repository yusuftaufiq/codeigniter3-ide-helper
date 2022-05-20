<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;

class ClassNodeVisitor extends NodeVisitor
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Class_) {
            $classNode = clone $node;
            $classNode->stmts = [];
            $this->nodes[] = $classNode;
        }

        return parent::enterNode($node);
    }

    public function getFirstFoundNode(): ?Node
    {
        return array_key_exists(0, $this->nodes) ? $this->nodes[0] : null;
    }

    public function getFoundNodes(): array
    {
        return [$this->nodes];
    }
}
