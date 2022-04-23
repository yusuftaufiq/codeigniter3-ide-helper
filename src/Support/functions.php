<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Support;

if (!\function_exists('Haemanthus\\CodeIgniter3IdeHelper\\Support\\pipe')) {
    function pipe(callable ...$functions): callable
    {
        return function ($arg) use ($functions) {
            return array_reduce($functions, fn ($carry, callable $function) => (
                $function($carry)
            ), $arg);
        };
    }
}
