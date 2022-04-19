<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeVisitorAbstract;

class ClassNodeVisitor extends NodeVisitorAbstract
{
    protected ?Class_ $class;

    public function enterNode(Node $node)
    {
        if ($node instanceof Class_) {
            $this->class = clone $node;
            $this->class->stmts = [];
        }

        return parent::enterNode($node);
    }

    public function getFoundClassNode(): ?Class_
    {
        return $this->class;
    }
}
