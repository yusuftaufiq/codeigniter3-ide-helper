<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;

interface FileParser
{
    /**
     * Undocumented function
     *
     * @return array<ClassStructuralElement>
     */
    public function parse(string $contents): array;
}
