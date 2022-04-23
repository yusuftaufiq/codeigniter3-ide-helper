<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

trait CastModelTrait
{
    protected function classTypeOf(string $name): string
    {
        $path = explode('/', $name);
        $modelName = $path[array_key_last($path)];

        return $modelName;
    }
}
