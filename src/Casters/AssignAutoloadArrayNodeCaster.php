<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Node;

class AssignAutoloadArrayNodeCaster extends NodeCaster
{
    public function cast(Node $node): array
    {
        $items = $node instanceof Node\Expr\Assign && $node->expr instanceof Node\Expr\Array_ ? $node->expr->items : [];

        return array_map(fn (Node\Expr\ArrayItem $item): ?PropertyStructuralElement => (
            $this->castExpressionArrayItem($item)
        ), $items);
    }
}
