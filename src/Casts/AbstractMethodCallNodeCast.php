<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDTO;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;

abstract class AbstractMethodCallNodeCast extends AbstractNodeCast
{
    protected static $classCategory;

    protected static $classParameterName;

    protected static $aliasParameterName;

    protected static $classParameterPosition;

    protected static $aliasParameterPosition;

    protected function classTypeOf(string $name): string
    {
        if (array_key_exists($name, $this->map[static::$classCategory] ?? []) === true) {
            return $this->map[static::$classCategory][$name];
        }

        return $name;
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return array<Arg>
     */
    protected function sortArguments(array $args): array
    {
        $key = 0;

        return array_reduce($args, function (array $carry, Arg $arg) use (&$key): array {
            switch (true) {
                case $arg->name instanceof Identifier === false:
                    $carry[$key] = $arg;
                    break;

                case $arg->name->name === static::$classParameterName:
                    $carry[static::$classParameterPosition] = $arg;
                    break;

                case $arg->name->name === static::$aliasParameterName:
                    $carry[static::$classParameterPosition] = $arg;
                    break;
            }

            $key += 1;

            return $carry;
        }, []);
    }

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
            && ($arg->value instanceof String_ || $arg->value instanceof ConstFetch)
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
            && ($arg->value instanceof Array_)
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return ?PropertyTagDTO
     */
    protected function castScalarStringArguments(array $args): ?PropertyTagDTO
    {
        if (array_key_exists(static::$classParameterPosition, $args) === false) {
            return null;
        }

        $className = $args[static::$classParameterPosition]->value->value;
        $hasAlias = array_key_exists(static::$aliasParameterPosition, $args);
        $propertyAlias = $hasAlias ? $args[static::$aliasParameterPosition]->value->value : null;
        $propertyName = $propertyAlias ?? $className;
        $propertyType = $this->classTypeOf($className);

        return new PropertyTagDTO($propertyName, $propertyType);
    }
}
