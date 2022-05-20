<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

interface FileNameMapper
{
    public function concreteFileNameOf(string $name): string;
}
