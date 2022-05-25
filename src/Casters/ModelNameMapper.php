<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\ClassNameMapper;

class ModelNameMapper implements ClassNameMapper
{
    public function concreteClassOf(string $name): string
    {
        $path = explode('/', $name);
        $modelName = $path[array_key_last($path)];

        return $modelName;
    }

    public function concreteNameOf(string $name): string
    {
        return $this->concreteClassOf($name);
    }
}
