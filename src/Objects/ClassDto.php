<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Objects;

use PhpParser\Node\Stmt\Class_;

class ClassDto
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

    public function getProperties(): array
    {
        return $this->properties;
    }
}
