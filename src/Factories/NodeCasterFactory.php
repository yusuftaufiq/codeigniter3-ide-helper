<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Casters;
use Haemanthus\CodeIgniter3IdeHelper\Casters\LibraryNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Casters\ModelNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster;
use Haemanthus\CodeIgniter3IdeHelper\Enums\NodeVisitorType;

class NodeCasterFactory
{
    protected LibraryNameMapper $libraryNameMapper;

    protected ModelNameMapper $modelNameMapper;

    public function __construct(
        LibraryNameMapper $libraryNameMapper,
        ModelNameMapper $modelNameMapper
    ) {
        $this->libraryNameMapper = $libraryNameMapper;
        $this->modelNameMapper = $modelNameMapper;
    }

    public function create(NodeVisitorType $type): NodeCaster
    {
        switch (true) {
            case $type->equals(NodeVisitorType::assignAutoloadLibrary()):
                return new Casters\AssignAutoloadArrayNodeCaster($this->libraryNameMapper);

            case $type->equals(NodeVisitorType::assignAutoloadModel()):
                return new Casters\AssignAutoloadArrayNodeCaster($this->modelNameMapper);

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

                return new Casters\MethodCallNodeCaster($this->libraryNameMapper, $methodCallNodeManager);

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

                return new Casters\MethodCallNodeCaster($this->modelNameMapper, $methodCallNodeManager);

            default:
                throw new \InvalidArgumentException("Unsupported file type for {$type->value}");
        }
    }
}
