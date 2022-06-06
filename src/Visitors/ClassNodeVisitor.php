<?php

declare(strict_types=1);

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
}
