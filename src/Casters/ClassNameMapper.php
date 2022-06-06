<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\ClassNameMapper as ClassNameMapperContract;

abstract class ClassNameMapper implements ClassNameMapperContract
{
    protected function fileNameOf(string $path): string
    {
        $paths = explode('/', $path);
        return $paths[array_key_last($paths)];
    }
}
