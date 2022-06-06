<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Casters;
use Haemanthus\CodeIgniter3IdeHelper\Casters\LibraryNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Casters\ModelNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;

class NodeCasterFactory
{
    public function create(NodeVisitorType $type): NodeCaster
    {
        switch (true) {
            case $type->equals(NodeVisitorType::assignAutoloadLibrary()):
                return new Casters\AssignAutoloadArrayNodeCaster(new LibraryNameMapper());

            case $type->equals(NodeVisitorType::assignAutoloadModel()):
                return new Casters\AssignAutoloadArrayNodeCaster(new ModelNameMapper());

            case $type->equals(NodeVisitorType::methodCallLoadLibrary()):
                $classParameterName = 'library';
                $aliasParameterName = 'object_name';
                $classParameterPosition = 0;
                $aliasParameterPosition = 2;

                $methodCallNodeManager = new Casters\MethodCallNodeManager(
                    $classParameterName,
                    $aliasParameterName,
                    $classParameterPosition,
                    $aliasParameterPosition,
                );

                return new Casters\MethodCallNodeCaster(new LibraryNameMapper(), $methodCallNodeManager);

            case $type->equals(NodeVisitorType::methodCallLoadModel()):
                $classParameterName = 'model';
                $aliasParameterName = 'name';
                $classParameterPosition = 0;
                $aliasParameterPosition = 1;

                $methodCallNodeManager = new Casters\MethodCallNodeManager(
                    $classParameterName,
                    $aliasParameterName,
                    $classParameterPosition,
                    $aliasParameterPosition,
                );

                return new Casters\MethodCallNodeCaster(new ModelNameMapper(), $methodCallNodeManager);

            default:
                throw new \InvalidArgumentException("Unsupported file type for {$type->value}");
        }
    }
}
