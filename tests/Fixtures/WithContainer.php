<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use DI\Container;
use DI\ContainerBuilder;
use Haemanthus\CodeIgniter3IdeHelper\Providers\AppServiceProvider;

trait WithContainer
{
    private Container $container;

    private function setUpContainer(): void
    {        
        $builder = new ContainerBuilder();
        $builder->addDefinitions(AppServiceProvider::definitions());

        $this->container = $builder->build();
    }
}
