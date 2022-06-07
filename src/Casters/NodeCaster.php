<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\ClassNameMapper;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeCaster as NodeCasterContract;
use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Node;

abstract class NodeCaster implements NodeCasterContract
{
    protected ClassNameMapper $classNameMapper;

    public function __construct(ClassNameMapper $classNameMapper)
    {
        $this->classNameMapper = $classNameMapper;
    }

    /**
     * Undocumented function
     *
     * @param array<Node\Arg> $args
     */
    protected function isArgumentsTypeScalarString(array $args): bool
    {
        return array_reduce($args, static fn (bool $carry, Node\Arg $arg): bool => (
            $arg->value instanceof Node\Scalar\String_ && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Node\Arg> $args
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
        $propertyAlias = $args[$aliasParameterPosition]->value->value ?? null;
        $propertyName = $this->classNameMapper->concreteNameOf($propertyAlias ?? $className);
        $propertyType = $this->classNameMapper->concreteClassOf($className);

        return new PropertyStructuralElement($propertyName, $propertyType);
    }

    /**
     * Undocumented function
     *
     * @param array<Node\Arg> $args
     */
    protected function isArgumentsTypeExpressionArray(array $args): bool
    {
        return array_reduce($args, static fn (bool $carry, Node\Arg $arg): bool => (
            $arg->value instanceof Node\Expr\Array_ && $carry
        ), true);
    }

    protected function castExpressionArrayItem(Node\Expr\ArrayItem $item): ?PropertyStructuralElement
    {
        if ($item->value instanceof Node\Scalar\String_ === false) {
            return null;
        }

        $propertyName = $this->classNameMapper->concreteNameOf($item->value->value);
        $className = $item->key instanceof Node\Scalar\String_ ? $item->key->value : $propertyName;
        $propertyType = $this->classNameMapper->concreteClassOf($className);

        return new PropertyStructuralElement($propertyName, $propertyType);
    }

    /**
     * Undocumented function
     *
     * @param array<Node\Arg> $args
     *
     * @return array<PropertyStructuralElement|null>
     */
    protected function castExpressionArrayArguments(
        array $args,
        int $classParameterPosition
    ): array {
        if (
            array_key_exists($classParameterPosition, $args) === false
            || $args[$classParameterPosition]->value instanceof Node\Expr\Array_ === false
        ) {
            return [];
        }

        return array_map(
            fn (?Node\Expr\ArrayItem $item): ?PropertyStructuralElement => (
                $item !== null ? $this->castExpressionArrayItem($item) : null
            ),
            $args[$classParameterPosition]->value->items,
        );
    }
}
