<?php

namespace Haemanthus\CodeIgniter3IdeHelper;

use DI\Container;
use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Commands\GenerateCommand;
use Haemanthus\CodeIgniter3IdeHelper\Providers\AppServiceProvider;
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
    public function registerCommands(): self
    {
        $this->app
            ->command(GenerateCommand::$expression, $this->container->make(GenerateCommand::class))
            ->descriptions(GenerateCommand::$description, GenerateCommand::$options);

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
