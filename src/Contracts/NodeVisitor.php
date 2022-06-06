<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use PhpParser\Node;
use PhpParser\NodeVisitor as PhpParserNodeVisitor;

interface NodeVisitor extends PhpParserNodeVisitor
{
    /**
     * Undocumented function
     *
     * @return array<Node>
     */
    public function getFoundNodes(): array;
}
