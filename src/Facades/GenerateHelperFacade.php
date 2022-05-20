<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

class GenerateHelperFacade
{
    protected ReaderFacade $reader;

    protected ParserFacade $parser;

    public function __construct(
        ReaderFacade $reader,
        ParserFacade $parser
    ) {
        $this->reader = $reader;
        $this->parser = $parser;
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

    public function generate(): void
    {
        $structuralElements = array_merge(
            $this->parser->parseAutoloadFile($this->reader->getAutoloadFile()),
            $this->parser->parseClassFiles($this->reader->getClassFiles()),
        );

        dd($structuralElements);
    }
}
