<?php

namespace Haemanthus\CodeIgniter3IdeHelper;

use DI\Container;
use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Commands\GenerateHelperCommand;
use Haemanthus\CodeIgniter3IdeHelper\Providers\AppServiceProvider;
use Haemanthus\CodeIgniter3IdeHelper\Support\VarDumper;
use Silly\Application as SillyApplication;

/**
 * Undocumented class
 */
class Application
{
    /**
     * Undocumented constant
     */
    protected const APP_NAME = 'CodeIgniter 3 IDE Helper';

    /**
     * Undocumented constant
     */
    protected const APP_VERSION = '0.1.0';

    /**
     * Undocumented variable
     *
     * @var \Silly\Application
     */
    protected SillyApplication $app;

    /**
     * Undocumented variable
     *
     * @var \DI\Container
     */
    protected Container $container;

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(AppServiceProvider::definitions());

        $this->app = new SillyApplication(static::APP_NAME, static::APP_VERSION);
        $this->container = $builder->build();
        $this->app->useContainer($this->container, true);
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function registerDevTools(): self
    {
        (new VarDumper())->handle();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function registerCommands(): self
    {
        $this->app
            ->command(GenerateHelperCommand::$expression, $this->container->make(GenerateHelperCommand::class))
            ->descriptions(GenerateHelperCommand::$description, GenerateHelperCommand::$options);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function run(): self
    {
        $this->app->run();

        return $this;
    }
}
