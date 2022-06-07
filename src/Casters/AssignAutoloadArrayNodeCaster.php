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

        return array_reduce($items, function (array $carry, ?Node\Expr\ArrayItem $item): array {
            if ($item === null) {
                return $carry;
            }

            $propertyStructuralElement = $this->castExpressionArrayItem($item);

            if ($propertyStructuralElement === null) {
                return $carry;
            }

            return array_merge($carry, [$propertyStructuralElement]);
        }, []);
    }
}
