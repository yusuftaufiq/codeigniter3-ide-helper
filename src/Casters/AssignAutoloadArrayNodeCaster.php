<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Node;

class AssignAutoloadArrayNodeCaster extends NodeCaster
{
    /**
     * Undocumented function
     *
     * @return array<PropertyStructuralElement>
     */
    public function cast(Node $node): array
    {
        $items = $node instanceof Node\Expr\Assign && $node->expr instanceof Node\Expr\Array_ ? $node->expr->items : [];

        $propertyStructuralElements = array_map(fn (Node\Expr\ArrayItem $item): ?PropertyStructuralElement => (
            $this->castExpressionArrayItem($item)
        ), $items);

        return array_filter($propertyStructuralElements);
    }
}
