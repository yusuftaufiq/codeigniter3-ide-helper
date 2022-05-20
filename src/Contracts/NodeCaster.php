<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use PhpParser\Node;

interface NodeCaster
{
    public function cast(Node $node): array;
}
