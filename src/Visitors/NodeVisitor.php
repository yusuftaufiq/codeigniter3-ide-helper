<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Visitors;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\NodeVisitor as NodeVisitorContract;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract implements NodeVisitorContract
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
