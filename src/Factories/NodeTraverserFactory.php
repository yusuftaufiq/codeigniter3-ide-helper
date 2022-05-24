<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use PhpParser\NodeTraverser;
use PhpParser\NodeTraverserInterface;

/**
 * Undocumented class
 */
class NodeTraverserFactory
{
    public function create(): NodeTraverserInterface
    {
        return new NodeTraverser();
    }
}
