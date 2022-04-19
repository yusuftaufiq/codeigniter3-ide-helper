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
    protected static $classCategory = 'libraries';

    protected static $classParameterName = 'library';

    protected static $aliasParameterName = 'object_name';

    protected static $classParameterPosition = 0;

    protected static $aliasParameterPosition = 2;

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
        if (array_key_exists(0, $args) === false) {
            return [];
        }

        return array_map(
            fn (ArrayItem $item) => $this->castExpressionArrayItem($item),
            $args[0]->value->items,
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
