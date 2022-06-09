<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper;

use Haemanthus\CodeIgniter3IdeHelper\Contracts\Command;

/**
 * Undocumented class
 */
class Application
{
    public const APP_NAME = 'CodeIgniter 3 IDE Helper';

    public const APP_VERSION = '1.0.4';

    public const APP_REPOSITORY = 'https://github.com/yusuftaufiq/codeigniter3-ide-helper';

    /**
     * Undocumented variable
     *
     * @var array<Command>
     */
    protected array $commands;

    protected \Silly\Application $silly;

    public function __construct(\Silly\Application $silly)
    {
        $this->silly = $silly;
    }

    public function addCommand(Command $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function run(): self
    {
        array_walk($this->commands, static function (Command $command): void {
            $command->execute();
        });

        $this->silly->run();

        return $this;
    }
}
