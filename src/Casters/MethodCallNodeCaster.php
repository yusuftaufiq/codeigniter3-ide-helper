<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\ClassNameMapper;
use PhpParser\Node;

class MethodCallNodeCaster extends NodeCaster
{
    protected MethodCallNodeManager $nodeManager;

    public function __construct(
        ClassNameMapper $classNameMapper,
        MethodCallNodeManager $nodeManager
    ) {
        parent::__construct($classNameMapper);
        $this->nodeManager = $nodeManager;
    }

    public function cast(Node $node): array
    {
        $args = $node instanceof Node\Expr\MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgumentsTypeScalarString($this->nodeManager->filter($args)):
                $propertyStructuralElements = [$this->castScalarStringArguments(
                    $this->nodeManager->sort($args),
                    $this->nodeManager->getClassParameterPosition(),
                    $this->nodeManager->getAliasParameterPosition(),
                )];
                break;

            case $this->isArgumentsTypeExpressionArray($this->nodeManager->filter($args)):
                $propertyStructuralElements = $this->castExpressionArrayArguments(
                    $this->nodeManager->sort($args),
                    $this->nodeManager->getClassParameterPosition(),
                );
                break;

            default:
                $propertyStructuralElements = [];
                break;
        }

        return $propertyStructuralElements;
    }
}
