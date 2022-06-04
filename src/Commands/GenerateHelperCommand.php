<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\Command;
use Haemanthus\CodeIgniter3IdeHelper\Facades\GenerateHelperFacade;
use Silly\Application as SillyApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Undocumented class
 */
class GenerateHelperCommand implements Command
{
    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    protected string $expression = 'generate [--dir=] [--pattern=]* [--output-path=]';

    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    protected string $description = 'Generate IDE helper file';

    /**
     * Undocumented variable
     *
     * @var array<string, string> $options
     */
    protected array $options = [
        '--dir' => 'CodeIgniter 3 root directory',
        '--pattern' => 'Pattern in string or regex to match files',
        '--output-path' => 'Output path of generated file',
    ];

    protected SillyApplication $app;

    protected GenerateHelperFacade $facade;

    public function __construct(
        SillyApplication $app,
        GenerateHelperFacade $facade
    ) {
        $this->app = $app;
        $this->facade = $facade;
    }

    public function execute(): void
    {
        $this->app
            ->command($this->expression, $this)
            ->defaults([
                'dir' => './',
                'pattern' => [],
                'output-path' => '_ide_helper.php',
            ])
            ->descriptions($this->description, $this->options);
    }

    public function __invoke(
        string $dir,
        array $pattern,
        string $outputPath,
        bool $noInteraction,
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->facade
            ->setInput($input)
            ->setOutput($output)
            ->withDirectory($dir)
            ->withPatterns($pattern)
            ->withOutputPath($outputPath)
            ->setInteractive(!$noInteraction);

        return $this->facade->generate();
    }
}
