<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Elements;

use PhpParser\Node\Stmt\Class_;

class ClassStructuralElement
{
    protected Class_ $node;

    protected array $properties;

    public function __construct(
        Class_ $node,
        array $properties = []
    ) {
        $this->node = $node;
        $this->properties = $properties;
    }

    public function getNode(): Class_
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
