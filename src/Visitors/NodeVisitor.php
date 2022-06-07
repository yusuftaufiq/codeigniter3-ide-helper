<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor as NodeVisitorContract;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

abstract class NodeVisitor extends NodeVisitorAbstract implements NodeVisitorContract
{
    /**
     * Undocumented variable
     *
     * @var array<Node>
     */
    protected array $nodes = [];

    /**
     * Undocumented function
     *
     * @return array<Node>
     */
    public function getFoundNodes(): array
    {
        return $this->nodes;
    }

    protected function isAssignAutoloadArray(Node $node): bool
    {
        return $node instanceof Node\Expr\Assign
            && $node->var instanceof Node\Expr\ArrayDimFetch
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'autoload'
            && $node->var->dim instanceof Node\Scalar\String_;
    }

    protected function isMethodCallThisLoad(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->name instanceof Node\Identifier
            && $node->var instanceof Node\Expr\PropertyFetch
            && $node->var->name instanceof Node\Identifier
            && $node->var->name->toString() === 'load'
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'this';
    }
}
