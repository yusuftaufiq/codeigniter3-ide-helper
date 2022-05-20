<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\Command;
use Haemanthus\CodeIgniter3IdeHelper\Facades\GenerateHelperFacade;
use Silly\Application as SillyApplication;

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
    protected string $expression = 'generate [--dir=] [--pattern=]* [--output=]';

    /**
     * Undocumented variable
     *
     * @var string $expression
     */
    protected string $description = 'Generate IDE Helper file';

    /**
     * Undocumented variable
     *
     * @var array<string, string> $options
     */
    protected array $options = [
        '--dir' => 'CodeIgniter 3 root directory',
        '--pattern' => 'Pattern in string or regex to match files',
        '--output' => 'Output filename'
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
            ->descriptions($this->description, $this->options);
    }

    public function __invoke(
        string $dir = '/./',
        array $pattern = [],
        string $output = '/./ide-helper.php'
    ) {
        $this->facade
            ->withDirectory($dir)
            ->withPatterns($pattern)
            ->generate();
    }
}
