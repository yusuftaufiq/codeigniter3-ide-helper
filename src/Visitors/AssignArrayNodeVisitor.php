<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class AssignArrayNodeVisitor extends NodeVisitorAbstract
{
    protected array $libraries = [];

    protected array $models = [];

    protected function isAssignArrayAutoload(Node $node): bool
    {
        return $node instanceof Node\Expr\Assign
            && $node->var instanceof Node\Expr\ArrayDimFetch
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'autoload';
    }

    protected function isAssignAutoloadLibrary(Node $node): bool
    {
        return $node instanceof Node\Expr\Assign
            && $node->var instanceof Node\Expr\ArrayDimFetch
            && $node->var->dim instanceof Node\Scalar\String_
            && $node->var->dim->value === 'libraries';
    }

    protected function isAssignAutoloadModel(Node $node): bool
    {
        return $node instanceof Node\Expr\Assign
            && $node->var instanceof Node\Expr\ArrayDimFetch
            && $node->var->dim instanceof Node\Scalar\String_
            && $node->var->dim->value === 'models';
    }

    public function enterNode(Node $node)
    {
        switch (true) {
            case $this->isAssignArrayAutoload($node) === false:
                return parent::enterNode($node);

            case $this->isAssignAutoloadLibrary($node):
                $this->libraries[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;

            case $this->isAssignAutoloadModel($node):
                $this->models[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;

            default:
                return parent::enterNode($node);
        }
    }

    public function getFoundAutoloadLibraryNodes()
    {
        return $this->libraries;
    }

    public function getFoundAutoloadModelNodes()
    {
        return $this->models;
    }
}
