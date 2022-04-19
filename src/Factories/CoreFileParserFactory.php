<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Factories;

use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadLibraryNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Casts\LoadModelNodeCast;
use Haemanthus\CodeIgniter3IdeHelper\Parsers\CoreFileParser;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

/**
 * Undocumented class
 */
class CoreFileParserFactory
{
    protected ParserFactory $parser;

    protected NodeTraverser $traverser;

    protected LoadLibraryNodeCast $loadLibraryNodeCast;

    protected LoadModelNodeCast $loadModelNodeCast;

    public function __construct(
        ParserFactory $parser,
        NodeTraverser $traverser,
        LoadLibraryNodeCast $loadLibraryNodeCast,
        LoadModelNodeCast $loadModelNodeCast
    ) {
        $this->parser = $parser;
        $this->traverser = $traverser;
        $this->loadLibraryNodeCast = $loadLibraryNodeCast;
        $this->loadModelNodeCast = $loadModelNodeCast;
    }

    /**
     * Undocumented function
     *
     * @return CoreFileParser
     */
    public function create(): CoreFileParser
    {
        return new CoreFileParser(
            $this->parser,
            $this->traverser,
            $this->loadLibraryNodeCast,
            $this->loadModelNodeCast,
        );
    }
}
