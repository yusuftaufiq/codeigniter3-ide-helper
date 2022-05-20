<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileNameMapper;

class ModelNameMapper implements FileNameMapper
{
    public function concreteFileNameOf(string $name): string
    {
        $path = explode('/', $name);
        $modelName = $path[array_key_last($path)];

        return $modelName;
    }
}
