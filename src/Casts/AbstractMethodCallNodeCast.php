<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDto;
use PhpParser\Node\Arg;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;

abstract class AbstractMethodCallNodeCast extends AbstractNodeCast
{
    protected static string $classParameterName;

    protected static string $aliasParameterName;

    protected static int $classParameterPosition;

    protected static int $aliasParameterPosition;

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
                    $carry[static::$aliasParameterPosition] = $arg;
                    break;
            }

            $key += 1;

            return $carry;
        }, []);
    }

    protected function filterOnlyRequiredArguments(array $args): array
    {
        return array_filter($args, fn (int $key): bool => (
            $key === static::$classParameterPosition
            || $key === static::$aliasParameterPosition
        ), \ARRAY_FILTER_USE_KEY);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return ?PropertyTagDto
     */
    protected function castScalarStringArguments(array $args): ?PropertyTagDto
    {
        if (
            array_key_exists(static::$classParameterPosition, $args) === false
            || $args[static::$classParameterPosition]->value instanceof String_ === false
        ) {
            return null;
        }

        $className = $args[static::$classParameterPosition]->value->value;
        $hasAlias = array_key_exists(static::$aliasParameterPosition, $args);
        $propertyAlias = $hasAlias ? $args[static::$aliasParameterPosition]->value->value : null;
        $propertyName = $propertyAlias ?? $className;
        $propertyType = $this->classTypeOf($className);

        return new PropertyTagDto($propertyName, $propertyType);
    }
}
