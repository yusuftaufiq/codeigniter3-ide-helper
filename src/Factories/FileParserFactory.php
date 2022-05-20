<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileParser;
use Haemanthus\CodeIgniter3IdeHelper\Enums\FileType;
use Haemanthus\CodeIgniter3IdeHelper\Parsers\AutoloadFileParser;
use Haemanthus\CodeIgniter3IdeHelper\Parsers\ClassFileParser;
use PhpParser\BuilderFactory;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

/**
 * Undocumented class
 */
class FileParserFactory
{
    protected ParserFactory $parser;

    protected NodeVisitorFactory $nodeVisitor;

    protected NodeCasterFactory $nodeCaster;

    protected BuilderFactory $nodeBuilder;

    public function __construct(
        ParserFactory $parser,
        NodeVisitorFactory $nodeVisitor,
        NodeCasterFactory $nodeCaster,
        BuilderFactory $nodeBuilder
    ) {
        $this->parser = $parser;
        $this->nodeVisitor = $nodeVisitor;
        $this->nodeCaster = $nodeCaster;
        $this->nodeBuilder = $nodeBuilder;
    }

    public function create(FileType $type): FileParser
    {
        switch (true) {
            case $type->equals(FileType::autoload()):
                return new AutoloadFileParser(
                    $this->parser,
                    new NodeTraverser(),
                    $this->nodeVisitor,
                    $this->nodeCaster,
                    $this->nodeBuilder
                );

            case $type->equals(FileType::core()):
            case $type->equals(FileType::controller()):
            case $type->equals(FileType::model()):
                return new ClassFileParser(
                    $this->parser,
                    new NodeTraverser(),
                    $this->nodeVisitor,
                    $this->nodeCaster
                );

            default:
                throw new \InvalidArgumentException("Unsupported file type for {$type->value}");
        }
    }
}
