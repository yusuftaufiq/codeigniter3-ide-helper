<?php

namespace Haemanthus\CodeIgniter3IdeHelper;

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

    public function __construct()
    {
        $this->app = new SillyApplication(static::APP_NAME, static::APP_VERSION);
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function registerCommands()
    {
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
