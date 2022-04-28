<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor as ContractNodeVisitor;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract implements ContractNodeVisitor
{
    protected array $nodes = [];

    public function getFirstFoundNode(): ?Node
    {
        return $this->nodes[0] ?? null;
    }

    public function getFoundNodes(): array
    {
        return $this->nodes;
    }
}
