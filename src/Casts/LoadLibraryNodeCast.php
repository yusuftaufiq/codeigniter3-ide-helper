<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use Haemanthus\CodeIgniter3IdeHelper\Objects\PropertyTagDTO;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;

class LoadLibraryNodeCast extends AbstractNodeCast
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
            ($arg->name === null || $arg->name instanceof Identifier)
            && ($arg->value instanceof String_ || $arg->value instanceof ConstFetch)
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return bool
     */
    public function isArgsTypeExpressionArray(array $args): bool
    {
        return array_reduce($args, fn (bool $carry, Arg $arg): bool => (
            ($arg->name === null || $arg->name instanceof Identifier)
            && ($arg->value instanceof Array_)
            && $carry
        ), true);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return array<Arg>
     */
    protected function sortArgs(array $args): array
    {
        $key = 0;

        return array_reduce($args, function (array $carry, Arg $arg) use (&$key): array {
            switch (true) {
                case $arg->name instanceof Identifier === false:
                    $carry[$key] = $arg;
                    break;

                case $arg->name->name === 'library':
                    $carry[0] = $arg;
                    break;

                case $arg->name->name === 'object_name':
                    $carry[2] = $arg;
                    break;
            }

            $key += 1;

            return $carry;
        }, []);
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return ?PropertyTagDTO
     */
    protected function castScalarStringArgs(array $args): ?PropertyTagDTO
    {
        if (sizeof($args) === 0) {
            return null;
        }

        $name = array_key_exists(2, $args) ? $args[2]->value->value : $args[0]->value->value;
        $type = $this->classType($args[0]->value->value);

        return new PropertyTagDTO(
            $name,
            $type,
        );
    }

    /**
     * Undocumented function
     *
     * @param array<Arg> $args
     * @return ?PropertyTagDTO
     */
    protected function castExpressionArrayArgs(array $args): ?PropertyTagDTO
    {
    }

    public function cast(Node $node): array
    {
        $args = $node instanceof MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgsTypeScalarString($args):
                $blocks = [$this->castScalarStringArgs($this->sortArgs($args))];
                break;

            case $this->isArgsTypeExpressionArray($args):
                $blocks = [];
                break;

            default:
                $blocks = [];
                break;
        }

        return $blocks;
    }
}