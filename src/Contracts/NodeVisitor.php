<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use PhpParser\Node;
use PhpParser\NodeVisitor as PhpParserNodeVisitor;

interface NodeVisitor extends PhpParserNodeVisitor
{
    public function getFoundFirstNode(): ?Node;

    public function getFoundNodes(): array;
}
