<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Providers;

use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Application;
use Haemanthus\CodeIgniter3IdeHelper\Commands\StartVarDumperCommand;
use Psr\Container\ContainerInterface;
use Silly\Application as SillyApplication;

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
            SillyApplication::class => function (ContainerInterface $container): SillyApplication {
                $silly = new SillyApplication(Application::APP_NAME, Application::APP_VERSION);
                $silly->useContainer($container);

                return $silly;
            },
            StartVarDumperCommand::class => function (): StartVarDumperCommand {
                if (getenv('VAR_DUMPER_HOST') === false) {
                    return new StartVarDumperCommand();
                }

                return new StartVarDumperCommand(getenv('VAR_DUMPER_HOST'));
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
