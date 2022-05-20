<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;

interface FileParser
{
    /**
     * Undocumented function
     *
     * @param string $contents
     *
     * @return array<ClassStructuralElement>
     */
    public function parse(string $contents): array;
}
