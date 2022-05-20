<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter;

class GenerateHelperFacade
{
    protected ReaderFacade $reader;

    protected ParserFacade $parser;

    protected FileWriter $writer;

    public function __construct(
        ReaderFacade $reader,
        ParserFacade $parser,
        FileWriter $writer
    ) {
        $this->reader = $reader;
        $this->parser = $parser;
        $this->writer = $writer;
    }

    public function withDirectory(string $directory): self
    {
        $this->reader->setRootDirectory($directory);

        return $this;
    }

    public function withPatterns(array $patterns): self
    {
        $this->reader->setPatterns($patterns);

        return $this;
    }

    public function withOutput(string $path): self
    {
        $this->writer->setOutputPath($path);

        return $this;
    }

    public function generate(): void
    {
        $structuralElements = array_merge(
            $this->parser->parseAutoloadFile($this->reader->getAutoloadFile()),
            $this->parser->parseClassFiles($this->reader->getClassFiles()),
        );

        $this->writer->write($structuralElements);
    }
}
