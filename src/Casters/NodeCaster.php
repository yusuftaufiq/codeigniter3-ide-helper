<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster as NodeCasterContract;
use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Node;

abstract class NodeCaster implements NodeCasterContract
{
    protected FileNameMapper $fileNameMapper;

    public function __construct(FileNameMapper $fileNameMapper)
    {
        $this->fileNameMapper = $fileNameMapper;
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return bool
     */
    protected function isArgumentsTypeScalarString(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Node\Arg $arg): bool => (
            ($arg->name === null || $arg->name instanceof Node\Identifier)
            && $arg->value instanceof Node\Scalar\String_
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return ?PropertyStructuralElement
     */
    protected function castScalarStringArguments(
        array $args,
        int $classParameterPosition,
        int $aliasParameterPosition
    ): ?PropertyStructuralElement {
        if (
            array_key_exists($classParameterPosition, $args) === false
            || $args[$classParameterPosition]->value instanceof Node\Scalar\String_ === false
        ) {
            return null;
        }

        $className = $args[$classParameterPosition]->value->value;
        $hasAlias = array_key_exists($aliasParameterPosition, $args);
        $propertyAlias = $hasAlias ? $args[$aliasParameterPosition]->value->value : null;
        $propertyName = $propertyAlias ?? $className;
        $propertyType = $this->fileNameMapper->concreteFileNameOf($className);

        return new PropertyStructuralElement($propertyName, $propertyType);
    }

    public function isArgumentsTypeExpressionArray(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Node\Arg $arg): bool => (
            ($arg->name === null || $arg->name instanceof Node\Identifier)
            && $arg->value instanceof Node\Expr\Array_
            && $carry
        ), true);
    }

    protected function castExpressionArrayItem(Node\Expr\ArrayItem $item): ?PropertyStructuralElement
    {
        if ($item->value instanceof Node\Scalar\String_ === false) {
            return null;
        }

        $propertyName = $item->value->value;
        $className = $item->key instanceof Node\Scalar\String_ ? $item->key->value : $propertyName;
        $propertyType = $this->fileNameMapper->concreteFileNameOf($className);

        return new PropertyStructuralElement($propertyName, $propertyType);
    }

    protected function castExpressionArrayArguments(
        array $args,
        int $classParameterPosition
    ): array {
        if (
            array_key_exists($classParameterPosition, $args) === false
            || $args[$classParameterPosition]->value instanceof Node\Scalar\String_ === false
        ) {
            return [];
        }

        return array_map(
            fn (Node\Expr\ArrayItem $item) => $this->castExpressionArrayItem($item),
            $args[$classParameterPosition]->value->items,
        );
    }
}
