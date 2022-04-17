<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Support;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper as SymfonyVarDumper;

class VarDumper
{
    protected const CLI_DUMPER = ['cli', 'phpdbg'];

    protected const DEFAULT_HOST = 'tcp://127.0.0.1:9912';

    protected function getServerHost(): string
    {
        return getenv('VAR_DUMPER_SERVER_HOST') ?: self::DEFAULT_HOST;
    }

    protected function serverHandler($var): void
    {
        $cloner = new VarCloner();
        $fallbackDumper = \in_array(\PHP_SAPI, self::CLI_DUMPER) ? new CliDumper() : new HtmlDumper();

        $dumper = new ServerDumper($this->getServerHost(), $fallbackDumper, [
            'cli' => new CliContextProvider(),
            'source' => new SourceContextProvider(),
        ]);

        $dumper->dump($cloner->cloneVar($var));
    }

    public function handle(): void
    {
        SymfonyVarDumper::setHandler(function ($var): void {
            $this->serverHandler($var);
        });
    }
}
