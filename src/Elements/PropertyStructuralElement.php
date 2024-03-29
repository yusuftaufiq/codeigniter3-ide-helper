<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Elements;

class PropertyStructuralElement
{
    protected string $name;

    protected ?string $type;

    public function __construct(
        string $name,
        ?string $type = null
    ) {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
