<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\DocumentBlockDTO;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;

class NodeLibraryCast extends AbstractNodeCast
{
    protected const KEY = 'libraries';

    protected function classType(string $name): string
    {
        if (array_key_exists($name, $this->map[self::KEY]) === true) {
            return $this->map[self::KEY][$name];
        }

        return $name;
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return bool
     */
    protected function isArgsTypeScalarString(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Arg $arg): bool => (
            $arg->name === null
            && ($arg->value instanceof String_ || $arg->value instanceof ConstFetch)
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return DocumentBlockDTO
     */
    protected function castScalarStringArg(array $args): DocumentBlockDTO
    {
        $name = array_key_exists(2, $args) ? $args[2]->value->value : $args[0]->value->value;
        $type = $this->classType($args[0]->value->value);

        return new DocumentBlockDTO(
            $name,
            $type,
        );
    }

    public function cast(MethodCall $node): ?DocumentBlockDTO
    {
        switch (true) {
            case $this->isArgsTypeScalarString($node->args):
                $block = $this->castScalarStringArg($node->args);
                break;

            default:
                $block = null;
                break;
        }

        return $block;
    }
}
