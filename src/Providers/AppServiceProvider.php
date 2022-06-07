<?php

declare(strict_types=1);

namespace Haemanthus\CodeIgniter3IdeHelper\Providers;

use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Helper\AutowireDefinitionHelper;
use Haemanthus\CodeIgniter3IdeHelper\Application;
use Haemanthus\CodeIgniter3IdeHelper\Contracts\FileWriter as FileWriterContract;
use Haemanthus\CodeIgniter3IdeHelper\Writers\FileWriter;
use Psr\Container\ContainerInterface;
use Silly\Application as SillyApplication;

use function DI\autowire;

/**
 * Undocumented class
 */
class AppServiceProvider
{
    protected static ?Container $container = null;

    /**
     * Undocumented function
     *
     * @return array<string, callable|AutowireDefinitionHelper>
     */
    public static function definitions(): array
    {
        return [
            FileWriterContract::class => autowire(FileWriter::class),
            SillyApplication::class => static function (ContainerInterface $container): SillyApplication {
                $silly = new SillyApplication(Application::APP_NAME, Application::APP_VERSION);
                $silly->useContainer($container);

                return $silly;
            },
        ];
    }

    public static function container(): Container
    {
        if (static::$container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(static::definitions());

            if (ENVIRONMENT === 'production') {
                $builder->enableCompilation(__DIR__ . '/../../tmp');
                $builder->writeProxiesToFile(true, __DIR__ . '/../../tmp/proxies');
            }

            static::$container = $builder->build();
        }

        return static::$container;
    }
}
