<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\Command;
use Haemanthus\CodeIgniter3IdeHelper\Services\GenerateHelperService;
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

    protected GenerateHelperService $service;

    public function __construct(
        SillyApplication $app,
        GenerateHelperService $service
    ) {
        $this->app = $app;
        $this->service = $service;
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
        $this->service
            ->withDirectory($dir)
            ->withPatterns($pattern)
            ->generate();
    }
}
