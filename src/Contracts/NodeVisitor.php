<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Contracts;

use PhpParser\Node;
use PhpParser\NodeVisitor as PhpParserNodeVisitor;

interface NodeVisitor extends PhpParserNodeVisitor
{
    public function getFirstFoundNode(): ?Node;

    public function getFoundNodes(): array;
}
