<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Commands;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\Command;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper as SymfonyVarDumper;

class StartVarDumperCommand implements Command
{
    protected string $host;

    protected array $dumpers;

    public function __construct(
        string $host = 'tcp://127.0.0.1:9912',
        array $dumpers = ['cli', 'phpdbg']
    ) {
        $this->host = $host;
        $this->dumpers = $dumpers;
    }

    public function execute(): void
    {
        SymfonyVarDumper::setHandler(function ($var): void {
            $cloner = new VarCloner();
            $fallbackDumper = \in_array(\PHP_SAPI, $this->dumpers) ? new CliDumper() : new HtmlDumper();

            $dumper = new ServerDumper($this->host, $fallbackDumper, [
                'cli' => new CliContextProvider(),
                'source' => new SourceContextProvider(),
            ]);

            $dumper->dump($cloner->cloneVar($var));
        });
    }
}
