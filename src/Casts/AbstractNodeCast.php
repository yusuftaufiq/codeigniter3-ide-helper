<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDto;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;

abstract class AbstractNodeCast
{
    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return bool
     */
    protected function isArgumentsTypeScalarString(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Arg $arg): bool => (
            ($arg->name === null || $arg->name instanceof Identifier)
            && $arg->value instanceof String_
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return bool
     */
    public function isArgumentsTypeExpressionArray(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Arg $arg): bool => (
            ($arg->name === null || $arg->name instanceof Identifier)
            && $arg->value instanceof Array_
            && $carry
        ), true);
    }

    protected function castExpressionArrayItem(ArrayItem $item): ?PropertyTagDto
    {
        if ($item->value instanceof String_ === false) {
            return null;
        }

        $propertyName = $item->value->value;
        $libraryClass = $item->key instanceof String_ ? $item->key->value : $propertyName;
        $propertyType = $this->classTypeOf($libraryClass);

        return new PropertyTagDto($propertyName, $propertyType);
    }

    abstract protected function classTypeOf(string $name): string;

    abstract public function cast(Node $node): array;
}
