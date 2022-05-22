<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Providers;

use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Application;
use Haemanthus\CodeIgniter3IdeHelper\Commands\StartVarDumperCommand;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter as FileWriterContract;
use Haemanthus\CodeIgniter3IdeHelper\Writers\FileWriter;
use Psr\Container\ContainerInterface;
use Silly\Application as SillyApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

use function DI\autowire;

/**
 * Undocumented class
 */
class AppServiceProvider
{
    protected static ?ContainerInterface $container = null;

    /**
     * Undocumented function
     *
     * @return array
     */
    protected static function definitions(): array
    {
        return [
            FileWriterContract::class => autowire(FileWriter::class),
            InputInterface::class => autowire(ArgvInput::class),
            OutputInterface::class => autowire(ConsoleOutput::class),
            SillyApplication::class => function (ContainerInterface $container): SillyApplication {
                $silly = new SillyApplication(Application::APP_NAME, Application::APP_VERSION);
                $silly->useContainer($container);

                return $silly;
            },
            StartVarDumperCommand::class => function (): StartVarDumperCommand {
                if (getenv('IDE_HELPER_VAR_DUMPER_HOST') === false) {
                    return new StartVarDumperCommand();
                }

                return new StartVarDumperCommand(getenv('IDE_HELPER_VAR_DUMPER_HOST'));
            },
        ];
    }

    public static function container(): ContainerInterface
    {
        if (static::$container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(static::definitions());

            static::$container = $builder->build();
        }

        return static::$container;
    }
}
