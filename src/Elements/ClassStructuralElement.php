<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Elements;

use PhpParser\Node;

class ClassStructuralElement
{
    protected Node\Stmt\Class_ $node;

    protected array $properties;

    public function __construct(
        Node\Stmt\Class_ $node,
        array $properties = []
    ) {
        $this->node = $node;
        $this->properties = $properties;
    }

    public function getNode(): Node\Stmt\Class_
    {
        return $this->node;
    }

    /**
     * Undocumented function
     *
     * @return array<PropertyStructuralElement>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
