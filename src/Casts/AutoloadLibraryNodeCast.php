<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDto;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Assign;

class AutoloadLibraryNodeCast extends AbstractAssignArrayNodeCast
{
    use CastLibraryTrait;

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
