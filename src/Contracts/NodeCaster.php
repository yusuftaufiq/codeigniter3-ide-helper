<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Haemanthus\CodeIgniter3IdeHelper\Elements\PropertyStructuralElement;
use PhpParser\Node;

interface NodeCaster
{
    /**
     * Undocumented function
     *
     * @return array<PropertyStructuralElement>
     */
    public function cast(Node $node): array;
}
