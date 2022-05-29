<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\ClassNameMapper as ClassNameMapperContract;

abstract class ClassNameMapper implements ClassNameMapperContract
{
    protected function fileNameOf(string $path): string
    {
        $paths = explode('/', $path);
        $name = $paths[array_key_last($paths)];

        return $name;
    }
}
