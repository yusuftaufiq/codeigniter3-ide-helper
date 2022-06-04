<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Facades;

use Haemanthus\CodeIgniter3IdeHelper\Application;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter;
use Silly\Command\Command as SillyCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class GenerateHelperFacade
{
    protected ReaderFacade $reader;

    protected ParserFacade $parser;

    protected FileWriter $writer;

    protected InputInterface $input;

    protected OutputInterface $output;

    protected QuestionHelper $question;

    protected int $availableAskAttempts = 2;

    public function __construct(
        ReaderFacade $reader,
        ParserFacade $parser,
        FileWriter $writer,
        QuestionHelper $question
    ) {
        $this->reader = $reader;
        $this->parser = $parser;
        $this->writer = $writer;
        $this->question = $question;
    }

    public function setInput(InputInterface $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function setOutput(OutputInterface $output): self
    {
        $this->output = $output;

        return $this;
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

    public function setInteractive(bool $interactive): self
    {
        $this->input->setInteractive($interactive);

        return $this;
    }

    protected function checkDirectory(): bool
    {
        while (
            $this->availableAskAttempts > 0
            && $this->reader->isAllDirectoryExists() === false
        ) {
            $this->availableAskAttempts -= 1;
            $this->output->writeln(
                "<fg=red>[x]</> CodeIgniter 3 directory can't be found.",
            );

            $question = new Question(
                "<fg=blue>[?]</> Please type the correct CodeIgniter 3 directory </><comment>[{$this->reader->getRootDirectory()}]</>: ",
                $this->reader->getRootDirectory(),
            );
            $newDirectory = $this->question->ask($this->input, $this->output, $question);

            $this->withDirectory($newDirectory);
        }

        if ($this->availableAskAttempts === 0) {
            $repository = Application::APP_REPOSITORY;

            $message = <<<EOT
            <fg=red>[x]</> Unfortunately, we still can't find your CodeIgniter 3 directory.
            Please try again or submit the issue to our <href=${repository}>repository</>.
            EOT;

            $this->output->writeln(preg_replace('/\s+/', ' ', $message));

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

        $this->output->writeln(
            "<fg=green>[i]</> Successfully generated IDE helper file to {$this->writer->getOutputPath()}",
        );

        return SillyCommand::SUCCESS;
    }
}
