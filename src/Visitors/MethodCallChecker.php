<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;

trait MethodCallChecker
{
    public function isMethodCallThisLoad(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->var instanceof Node\Expr\PropertyFetch
            && $node->var->name->toString() === 'load'
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'this'
            && $node->var->name instanceof Node\Identifier;
    }
}
