<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Support;

if (!\function_exists('Haemanthus\\CodeIgniter3IdeHelper\\Support\\pipe')) {
    function pipe(callable ...$functions): mixed
    {
        return fn (mixed $value) => array_reduce(
            $functions,
            fn (mixed $carry, callable $function) => $function($carry),
            $value
        );
    }
}
