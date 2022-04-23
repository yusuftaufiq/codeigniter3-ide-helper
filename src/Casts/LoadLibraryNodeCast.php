<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDto;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;

class LoadLibraryNodeCast extends AbstractMethodCallNodeCast
{
    use CastLibraryTrait;

    protected static string $classParameterName = 'library';

    protected static string $aliasParameterName = 'object_name';

    protected static int $classParameterPosition = 0;

    protected static int $aliasParameterPosition = 2;

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return array<?PropertyTagDto>
     */
    protected function castExpressionArrayArguments(array $args): array
    {
        if (
            array_key_exists(static::$classParameterPosition, $args) === false
            || $args[static::$classParameterPosition]->value instanceof String_ === false
        ) {
            return [];
        }

        return array_map(
            fn (ArrayItem $item) => $this->castExpressionArrayItem($item),
            $args[static::$classParameterPosition]->value->items,
        );
    }

    /**
     * TODO: Reduce time complexity
     */
    public function cast(Node $node): array
    {
        $args = $node instanceof MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgumentsTypeScalarString($this->filterOnlyRequiredArguments($args)):
                $blocks = [$this->castScalarStringArguments($this->sortArguments($args))];
                break;

            case $this->isArgumentsTypeExpressionArray($this->filterOnlyRequiredArguments($args)):
                $blocks = $this->castExpressionArrayArguments($this->sortArguments($args));
                break;

            default:
                $blocks = [];
                break;
        }

        return $blocks;
    }
}
