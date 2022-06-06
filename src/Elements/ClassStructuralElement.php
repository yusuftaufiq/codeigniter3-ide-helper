<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Elements;

use PhpParser\Node;

class ClassStructuralElement
{
    protected Node\Stmt\Class_ $node;

    /**
     * Undocumented variable
     *
     * @var array<PropertyStructuralElement>
     */
    protected array $properties;

    /**
     * Undocumented function
     *
     * @param array<PropertyStructuralElement> $properties
     */
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
