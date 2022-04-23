<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDto;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Scalar\String_;

class AutoloadLibraryNodeCast extends AbstractAssignArrayNodeCast
{
    protected function classTypeOf(string $name): string
    {
        if (array_key_exists($name, $this->mapLibraries) === true) {
            return $this->mapLibraries[$name];
        }

        return $name;
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

    protected function castExpressionArrayItems(array $items): array
    {
        return array_map(fn (ArrayItem $item): ?PropertyTagDto => (
            $this->castExpressionArrayItem($item)
        ), $items);
    }

    public function cast(Node $node): array
    {
        $items = $node instanceof Assign && $node->expr instanceof Array_ ? $node->expr->items : [];

        return $this->castExpressionArrayItems($items);
    }
}
