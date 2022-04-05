<?php

namespace Haemanthus\CodeIgniter3IdeHelper;

use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Commands\Generate;
use Haemanthus\CodeIgniter3IdeHelper\Providers\AppServiceProvider;
use Silly\Application as SillyApplication;

class Application
{
    const APP_NAME = 'CodeIgniter 3 IDE Helper';

    const APP_VERSION = '0.1.0';

    /**
     * Undocumented variable
     *
     * @var \Silly\Application
     */
    protected $app;

    /**
     * Undocumented variable
     *
     * @var \DI\Container
     */
    protected $container;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(AppServiceProvider::register());

        $this->app = new SillyApplication(static::APP_NAME, static::APP_VERSION);
        $this->container = $builder->build();
        $this->app->useContainer($this->container, true);
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function registerCommands()
    {
        $this->app
            ->command(Generate::$expression, $this->container->call(Generate::class))
            ->descriptions(Generate::$description, Generate::$options);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function run()
    {
        $this->app->run();

        return $this;
    }
}
