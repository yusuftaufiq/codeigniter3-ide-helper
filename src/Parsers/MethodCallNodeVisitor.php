<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Parsers;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class MethodCallNodeVisitor extends NodeVisitorAbstract
{
    protected array $libraries = [];

    protected array $models = [];

    protected function isCallLoadMethod(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->var instanceof Node\Expr\PropertyFetch
            && $node->var->name->toString() === 'load'
            && $node->var->var instanceof Node\Expr\Variable
            && $node->var->var->name === 'this'
            && $node->var->name instanceof Node\Identifier;
    }

    protected function isCallLoadLibraryMethod(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->name->toString() === 'library';
    }

    protected function isCallLoadModelMethod(Node $node): bool
    {
        return $node instanceof Node\Expr\MethodCall
            && $node->name->toString() === 'model';
    }

    public function enterNode(Node $node)
    {
        switch (true) {
            case $this->isCallLoadMethod($node) === false:
                return parent::enterNode($node);

            case $this->isCallLoadLibraryMethod($node):
                $this->libraries[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;

            case $this->isCallLoadModelMethod($node):
                $this->models[] = $node;

                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        }
    }

    public function getFoundLibraryNodes()
    {
        return $this->libraries;
    }

    public function getFoundModelNodes()
    {
        return $this->models;
    }
}
