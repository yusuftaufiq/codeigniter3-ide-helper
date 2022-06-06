<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use Haemanthus\CodeIgniter3IdeHelper\Elements\ClassStructuralElement;

interface FileWriter
{
    public function getOutputPath(): string;

    public function setOutputPath(string $outputPath): self;

    /**
     * Undocumented function
     *
     * @param array<ClassStructuralElement> $classStructuralElements
     */
    public function write(array $classStructuralElements): self;
}
