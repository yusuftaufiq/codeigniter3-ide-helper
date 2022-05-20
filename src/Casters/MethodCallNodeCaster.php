<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileNameMapper;
use PhpParser\Node;

class MethodCallNodeCaster extends NodeCaster
{
    protected MethodCallNodeManager $nodeManager;

    public function __construct(
        FileNameMapper $fileNameMapper,
        MethodCallNodeManager $nodeManager
    ) {
        parent::__construct($fileNameMapper);
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
