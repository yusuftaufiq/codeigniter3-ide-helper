<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;
use Haemanthus\CodeIgniter3IdeHelper\Visitors;

final class NodeVisitorFactory
{
    public function create(NodeVisitorType $type): NodeVisitor
    {
        switch (true) {
            case $type->equals(NodeVisitorType::assignAutoloadLibrary()):
                return new Visitors\AssignAutoloadLibraryNodeVisitor();

            case $type->equals(NodeVisitorType::assignAutoloadModel()):
                return new Visitors\AssignAutoloadModelNodeVisitor();

            case $type->equals(NodeVisitorType::methodCallLoadLibrary()):
                return new Visitors\MethodCallLoadLibraryNodeVisitor();

            case $type->equals(NodeVisitorType::methodCallLoadModel()):
                return new Visitors\MethodCallLoadModelNodeVisitor();

            default:
                throw new \Exception("Unknown node visitor type: ${type}");
        }
    }
}
