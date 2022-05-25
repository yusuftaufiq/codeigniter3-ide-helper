<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

interface ClassNameMapper
{
    public function concreteNameOf(string $name): string;

    public function concreteClassOf(string $name): string;
}
