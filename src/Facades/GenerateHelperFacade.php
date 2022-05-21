<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Application;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter;
use Silly\Command\Command as SillyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateHelperFacade
{
    protected ReaderFacade $reader;

    protected ParserFacade $parser;

    protected FileWriter $writer;

    protected SymfonyStyle $io;

    protected int $availableAskAttempts = 2;

    public function __construct(
        ReaderFacade $reader,
        ParserFacade $parser,
        FileWriter $writer,
        SymfonyStyle $io
    ) {
        $this->reader = $reader;
        $this->parser = $parser;
        $this->writer = $writer;
        $this->io = $io;
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

    public function withOutputPath(string $path): self
    {
        $this->writer->setOutputPath($path);

        return $this;
    }

    protected function checkDirectory(): bool
    {
        while (
            $this->availableAskAttempts > 0
            && $this->reader->isAllDirectoryExists() === false
        ) {
            $this->availableAskAttempts -= 1;

            $this->io->error("CodeIgniter 3 directory can't be found");

            $this->withDirectory($this->io->ask('Please enter a valid CodeIgniter 3 directory again', './'));
        }

        if ($this->availableAskAttempts === 0) {
            $repository = Application::APP_REPOSITORY;

            $message = <<<TXT
Unfortunately, we still can't find your CodeIgniter 3 directory.
Please try again or submit the issue to our repository at ${repository}.
TXT;

            $this->io->error(preg_replace('/\s+/', ' ', $message));

            return false;
        }

        return true;
    }

    public function generate(): int
    {
        if ($this->checkDirectory() === false) {
            return SillyCommand::FAILURE;
        }

        $structuralElements = array_merge(
            $this->parser->parseAutoloadFile($this->reader->getAutoloadFile()),
            $this->parser->parseClassFiles($this->reader->getClassFiles()),
        );

        $this->writer->write($structuralElements);

        $this->io->success('Successfully generated IDE Helper file');

        return SillyCommand::SUCCESS;
    }
}
