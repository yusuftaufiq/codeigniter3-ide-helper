<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

interface FileWriter
{
    public function getOutputPath(): string;

    public function setOutputPath(string $outputPath): self;

    public function write(array $classStructuralElements): self;
}
