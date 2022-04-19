<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDTO;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;

class LoadLibraryNodeCast extends AbstractMethodCallNodeCast
{
    protected static string $classCategory = 'libraries';

    protected static string $classParameterName = 'library';

    protected static string $aliasParameterName = 'object_name';

    protected static int $classParameterPosition = 0;

    protected static int $aliasParameterPosition = 2;

    protected function classTypeOf(string $name): string
    {
        if (array_key_exists($name, $this->map[static::$classCategory] ?? []) === true) {
            return $this->map[static::$classCategory][$name];
        }

        return $name;
    }

    protected function castExpressionArrayItem(ArrayItem $item): ?PropertyTagDTO
    {
        if ($item->value instanceof String_ === false) {
            return null;
        }

        $propertyName = $item->value->value;
        $libraryClass = $item->key instanceof String_ ? $item->key->value : $propertyName;
        $propertyType = $this->classTypeOf($libraryClass);

        return new PropertyTagDTO($propertyName, $propertyType);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return array<?PropertyTagDTO>
     */
    protected function castExpressionArrayArguments(array $args): array
    {
        if (array_key_exists(static::$classParameterPosition, $args) === false) {
            return [];
        }

        return array_map(
            fn (ArrayItem $item) => $this->castExpressionArrayItem($item),
            $args[static::$classParameterPosition]->value->items,
        );
    }

    public function cast(Node $node): array
    {
        $args = $node instanceof MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgumentsTypeScalarString($args):
                $blocks = [$this->castScalarStringArguments($this->sortArguments($args))];
                break;

            case $this->isArgumentsTypeExpressionArray($args):
                $blocks = $this->castExpressionArrayArguments($this->sortArguments($args));
                break;

            default:
                $blocks = [];
                break;
        }

        return $blocks;
    }
}
