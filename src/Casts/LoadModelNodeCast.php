<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Casts;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;

class LoadModelNodeCast extends AbstractMethodCallNodeCast
{
    use CastModelTrait;

    protected static string $classParameterName = 'model';

    protected static string $aliasParameterName = 'name';

    protected static int $classParameterPosition = 0;

    protected static int $aliasParameterPosition = 1;

    /**
     * TODO: Reduce time complexity
     */
    public function cast(Node $node): array
    {
        $args = $node instanceof MethodCall ? $node->getArgs() : [];

        switch (true) {
            case $this->isArgumentsTypeScalarString($this->filterOnlyRequiredArguments($args)):
                $blocks = [$this->castScalarStringArguments($this->sortArguments($args))];
                break;

            default:
                $blocks = [];
                break;
        }

        return $blocks;
    }
}
