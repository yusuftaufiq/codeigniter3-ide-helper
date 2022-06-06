<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

class ModelNameMapper extends ClassNameMapper
{
    public function concreteClassOf(string $name): string
    {
        return $this->fileNameOf($name);
    }

    public function concreteNameOf(string $name): string
    {
        return $this->fileNameOf($name);
    }
}
