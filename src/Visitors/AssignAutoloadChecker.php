<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;

trait AssignAutoloadChecker
{
    public function isAssignAutoloadArray(Node $node): bool
    {
        return $node instanceof Node\Expr\Assign
            && $node->var instanceof Node\Expr\ArrayDimFetch
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'autoload'
            && $node->var->dim instanceof Node\Scalar\String_;
    }
}
