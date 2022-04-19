<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class MethodCallNodeVisitor extends NodeVisitorAbstract
{
    protected array $libraries = [];

    protected array $models = [];

    protected function isMethodCallThisLoad(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->var instanceof Node\Expr\PropertyFetch
            && $node->var->name->toString() === 'load'
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'this'
            && $node->var->name instanceof Node\Identifier;
    }

    protected function isMethodCallLoadLibrary(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->name->toString() === 'library';
    }

    protected function isMethodCallLoadModel(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->name->toString() === 'model';
    }

    public function enterNode(Node $node)
    {
        switch (true) {
            case $this->isMethodCallThisLoad($node) === false:
                return parent::enterNode($node);

            case $this->isMethodCallLoadLibrary($node):
                $this->libraries[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;

            case $this->isMethodCallLoadModel($node):
                $this->models[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;

            default:
                return parent::enterNode($node);
        }
    }

    public function getFoundLoadLibraryNodes()
    {
        return $this->libraries;
    }

    public function getFoundLoadModelNodes()
    {
        return $this->models;
    }
}
