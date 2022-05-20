<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casters;

use PhpParser\Node;

class MethodCallNodeManager
{
    protected string $classParameterName;

    protected string $aliasParameterName;

    protected int $classParameterPosition;

    protected int $aliasParameterPosition;

    public function __construct(
        string $classParameterName,
        string $aliasParameterName,
        int $classParameterPosition,
        int $aliasParameterPosition
    ) {
        $this->classParameterName = $classParameterName;
        $this->aliasParameterName = $aliasParameterName;
        $this->classParameterPosition = $classParameterPosition;
        $this->aliasParameterPosition = $aliasParameterPosition;
    }

    public function getClassParameterName(): string
    {
        return $this->classParameterName;
    }

    public function getAliasParameterName(): string
    {
        return $this->aliasParameterName;
    }

    public function getClassParameterPosition(): int
    {
        return $this->classParameterPosition;
    }

    public function getAliasParameterPosition(): int
    {
        return $this->aliasParameterPosition;
    }

    public function sort(array $nodes): array
    {
        $key = 0;

        return array_reduce($nodes, function (array $carry, Node\Arg $argument) use (&$key): array {
            switch (true) {
                case $argument->name instanceof Node\Identifier === false:
                    $carry[$key] = $argument;
                    break;

                case $argument->name->name === $this->classParameterName:
                    $carry[$this->classParameterPosition] = $argument;
                    break;

                case $argument->name->name === $this->aliasParameterName:
                    $carry[$this->aliasParameterPosition] = $argument;
                    break;
            }

            $key += 1;

            return $carry;
        }, []);
    }

    public function filter(array $nodes): array
    {
        return array_filter($nodes, fn (int $key): bool => (
            $key === $this->classParameterPosition
            || $key === $this->aliasParameterPosition
        ), \ARRAY_FILTER_USE_KEY);
    }
}
