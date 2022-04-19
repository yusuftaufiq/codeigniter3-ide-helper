<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;

class LoadModelNodeCast extends AbstractMethodCallNodeCast
{
    protected static $classParameterName = 'model';

    protected static $aliasParameterName = 'name';

    protected static $classParameterPosition = 0;

    protected static $aliasParameterPosition = 1;

    protected function classTypeOf(string $name): string
    {
        $path = explode('/', $name);
        $modelName = $path[array_key_last($path)];

        return $modelName;
    }

    public function cast(Node $node): array
    {
        $args = $node instanceof MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgumentsTypeScalarString($args):
                $blocks = [$this->castScalarStringArguments($this->sortArguments($args))];
                break;

            default:
                $blocks = [];
                break;
        }

        return $blocks;
    }
}
